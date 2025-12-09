<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Logs Viewer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 13px;
        }
        .log-viewer {
            max-width: 1400px;
            margin: 20px auto;
            padding: 20px;
        }
        .log-header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .log-entry {
            background: white;
            border-left: 4px solid #6c757d;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }
        .log-entry:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }
        .log-entry.error {
            border-left-color: #dc3545;
            background: #fff5f5;
        }
        .log-entry.warning {
            border-left-color: #ffc107;
            background: #fffbf0;
        }
        .log-entry.info {
            border-left-color: #0dcaf0;
            background: #f0f9ff;
        }
        .log-entry.debug {
            border-left-color: #6c757d;
            background: #f8f9fa;
        }
        .log-timestamp {
            color: #6c757d;
            font-size: 12px;
            margin-right: 10px;
        }
        .log-level {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
            margin-right: 10px;
        }
        .log-level.ERROR {
            background: #dc3545;
            color: white;
        }
        .log-level.WARNING {
            background: #ffc107;
            color: #000;
        }
        .log-level.INFO {
            background: #0dcaf0;
            color: #000;
        }
        .log-level.DEBUG {
            background: #6c757d;
            color: white;
        }
        .log-message {
            margin-top: 8px;
            line-height: 1.6;
            word-wrap: break-word;
        }
        .log-context {
            margin-top: 10px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 4px;
            font-size: 12px;
            overflow-x: auto;
        }
        .log-context pre {
            margin: 0;
            white-space: pre-wrap;
        }
        .filter-section {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .stats {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }
        .stat-item {
            padding: 10px 15px;
            background: #f8f9fa;
            border-radius: 4px;
            font-size: 12px;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="log-viewer">
        <div class="log-header">
            <h2>📋 Laravel Logs Viewer</h2>
            <p class="text-muted mb-3">View and filter your application logs</p>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="GET" action="{{ route('logs.viewer') }}" class="filter-section">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Search logs..."
                       value="{{ $search ?? '' }}"
                       style="max-width: 300px;">

                <select name="level" class="form-select" style="max-width: 150px;">
                    <option value="all" {{ ($level ?? 'all') == 'all' ? 'selected' : '' }}>All Levels</option>
                    <option value="error" {{ ($level ?? '') == 'error' ? 'selected' : '' }}>Error</option>
                    <option value="warning" {{ ($level ?? '') == 'warning' ? 'selected' : '' }}>Warning</option>
                    <option value="info" {{ ($level ?? '') == 'info' ? 'selected' : '' }}>Info</option>
                    <option value="debug" {{ ($level ?? '') == 'debug' ? 'selected' : '' }}>Debug</option>
                </select>

                <select name="lines" class="form-select" style="max-width: 150px;">
                    <option value="50" {{ ($lines ?? 100) == 50 ? 'selected' : '' }}>Last 50 lines</option>
                    <option value="100" {{ ($lines ?? 100) == 100 ? 'selected' : '' }}>Last 100 lines</option>
                    <option value="200" {{ ($lines ?? 100) == 200 ? 'selected' : '' }}>Last 200 lines</option>
                    <option value="500" {{ ($lines ?? 100) == 500 ? 'selected' : '' }}>Last 500 lines</option>
                </select>

                <button type="submit" class="btn btn-primary">
                    🔍 Filter
                </button>

                <a href="{{ route('logs.viewer') }}" class="btn btn-secondary">
                    🔄 Reset
                </a>

                <form method="POST" action="{{ route('logs.clear') }}" style="display: inline;"
                      onsubmit="return confirm('Are you sure you want to clear all logs?');">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        🗑️ Clear Logs
                    </button>
                </form>
            </form>

            <div class="stats">
                <div class="stat-item">
                    <strong>Total Entries:</strong> {{ count($logs) }}
                </div>
                <div class="stat-item">
                    <strong>Showing:</strong> {{ $lines ?? 100 }} lines
                </div>
            </div>
        </div>

        @if($message)
            <div class="empty-state">
                <div>⚠️</div>
                <h4>{{ $message }}</h4>
            </div>
        @elseif(empty($logs))
            <div class="empty-state">
                <div>📭</div>
                <h4>No logs found</h4>
                <p>Try adjusting your filters or check back later</p>
            </div>
        @else
            @foreach($logs as $log)
                <div class="log-entry {{ strtolower($log['level']) }}">
                    <div>
                        <span class="log-timestamp">{{ $log['timestamp'] }}</span>
                        <span class="log-level {{ $log['level'] }}">{{ $log['level'] }}</span>
                    </div>
                    <div class="log-message">
                        {{ $log['message'] }}
                    </div>
                    @if($log['context'])
                        <div class="log-context">
                            <pre>{{ $log['context'] }}</pre>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
