<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Mail\BroadcastNewsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriberController extends Controller
{
    /**
     * Display a listing of subscribers
     */
    public function index(Request $request)
    {
        $query = Subscriber::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by email
        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        $subscribers = $query->orderBy('created_at', 'desc')->paginate(20);

        // Stats
        $stats = [
            'total' => Subscriber::count(),
            'active' => Subscriber::active()->count(),
            'unsubscribed' => Subscriber::where('status', 'unsubscribed')->count(),
        ];

        return view('admin.subscribers.index', compact('subscribers', 'stats'));
    }

    /**
     * Remove the specified subscriber
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')
            ->with('success', 'Subscriber deleted successfully.');
    }

    /**
     * Toggle subscriber status
     */
    public function toggleStatus(Subscriber $subscriber)
    {
        if ($subscriber->status === 'active') {
            $subscriber->unsubscribe();
            $message = 'Subscriber has been deactivated.';
        } else {
            $subscriber->resubscribe();
            $message = 'Subscriber has been activated.';
        }

        return redirect()->route('admin.subscribers.index')
            ->with('success', $message);
    }

    /**
     * Export subscribers to CSV
     */
    public function export(Request $request): StreamedResponse
    {
        $status = $request->get('status', 'active');

        $filename = 'subscribers-' . $status . '-' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($status) {
            $handle = fopen('php://output', 'w');

            // CSV Header
            fputcsv($handle, ['Email', 'Status', 'Subscribed At', 'IP Address']);

            // Get subscribers based on status
            $query = Subscriber::query();
            if ($status !== 'all') {
                $query->where('status', $status);
            }

            $query->orderBy('created_at', 'desc')
                ->chunk(100, function ($subscribers) use ($handle) {
                    foreach ($subscribers as $subscriber) {
                        fputcsv($handle, [
                            $subscriber->email,
                            $subscriber->status,
                            $subscriber->subscribed_at?->format('Y-m-d H:i:s'),
                            $subscriber->ip_address,
                        ]);
                    }
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Bulk delete subscribers
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->route('admin.subscribers.index')
                ->with('error', 'No subscribers selected.');
        }

        Subscriber::whereIn('id', $ids)->delete();

        return redirect()->route('admin.subscribers.index')
            ->with('success', count($ids) . ' subscribers deleted successfully.');
    }

    /**
     * Show broadcast form
     */
    public function broadcast()
    {
        $activeCount = Subscriber::active()->count();

        return view('admin.subscribers.broadcast', compact('activeCount'));
    }

    /**
     * Send broadcast email to all active subscribers
     */
    public function sendBroadcast(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $subscribers = Subscriber::active()->get();

        if ($subscribers->isEmpty()) {
            return redirect()->route('admin.subscribers.broadcast')
                ->with('error', 'No active subscribers to send email to.');
        }

        $successCount = 0;
        $failCount = 0;

        foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)->send(
                    new BroadcastNewsletter(
                        $request->subject,
                        $request->content,
                        $subscriber
                    )
                );
                $successCount++;
            } catch (\Exception $e) {
                $failCount++;
                Log::error('Failed to send email to ' . $subscriber->email . ': ' . $e->getMessage());
            }
        }

        $message = "Broadcast sent successfully to {$successCount} subscriber(s).";
        if ($failCount > 0) {
            $message .= " {$failCount} failed.";
        }

        return redirect()->route('admin.subscribers.index')
            ->with('success', $message);
    }
}
