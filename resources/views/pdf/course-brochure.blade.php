<!DOCTYPE html>
<html>
<head>
    <title>{{ $course->title }} - Brochure</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .section { margin-bottom: 20px; }
        h1, h2 { color: #c53030; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>{{ $course->title }}</h1>
    <div class="section">
        <p><strong>Duration:</strong> {{ $course->duration }}</p>
        <p><strong>Price:</strong> ${{ number_format($course->fee, 2) }}</p>
        <p><strong>Mode:</strong> {{ $course->is_online ? 'Online' : 'On-Campus' }}</p>
    </div>

    <div class="section">
        <h2>Overview</h2>
        <p>{{ $course->description }}</p>
    </div>

    @if ($course->modules && count($course->modules))
    <div class="section">
        <h2>Modules</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Module Title</th>
                    <th>Credits</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($course->modules as $index => $module)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $module->name }}</td>
                        <td>{{ $module->credits }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</body>
</html>
