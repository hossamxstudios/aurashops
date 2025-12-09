<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogViewerController extends Controller
{
    public function index(Request $request)
    {
        $logFile = storage_path('logs/laravel.log');

        if (!File::exists($logFile)) {
            return view('website.pages.logs.viewer', [
                'logs' => [],
                'message' => 'No log file found'
            ]);
        }

        // Get filter parameters
        $search = $request->get('search', '');
        $level = $request->get('level', 'all');
        $lines = $request->get('lines', 100);

        // Read last N lines
        $logContent = $this->readLastLines($logFile, $lines);

        // Parse logs
        $logs = $this->parseLogs($logContent);

        // Filter by search
        if ($search) {
            $logs = array_filter($logs, function($log) use ($search) {
                return stripos($log['message'], $search) !== false ||
                       stripos($log['context'], $search) !== false;
            });
        }

        // Filter by level
        if ($level !== 'all') {
            $logs = array_filter($logs, function($log) use ($level) {
                return strtolower($log['level']) === strtolower($level);
            });
        }

        return view('website.pages.logs.viewer', [
            'logs' => array_reverse($logs),
            'search' => $search,
            'level' => $level,
            'lines' => $lines,
            'message' => null
        ]);
    }

    private function readLastLines($file, $lines = 100)
    {
        $handle = fopen($file, 'r');
        $lineArray = [];

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $lineArray[] = $line;
                if (count($lineArray) > $lines) {
                    array_shift($lineArray);
                }
            }
            fclose($handle);
        }

        return implode('', $lineArray);
    }

    private function parseLogs($content)
    {
        $logs = [];
        $pattern = '/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] \w+\.(\w+): (.*?)(?=\[\d{4}|$)/s';

        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $message = trim($match[3]);
            $context = '';

            // Check if there's JSON context
            if (preg_match('/(.*?)(\{.*\}|\[.*\])/s', $message, $parts)) {
                $message = trim($parts[1]);
                $context = $parts[2];
            }

            $logs[] = [
                'timestamp' => $match[1],
                'level' => strtoupper($match[2]),
                'message' => $message,
                'context' => $context
            ];
        }

        return $logs;
    }

    public function clear()
    {
        $logFile = storage_path('logs/laravel.log');

        if (File::exists($logFile)) {
            File::put($logFile, '');
        }

        return redirect()->route('logs.viewer')->with('success', 'Logs cleared successfully!');
    }
}
