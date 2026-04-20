<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
</head>
<body style="font-family: system-ui, sans-serif; line-height: 1.5; color: #1a1a1a;">
@if($toAdmin)
    <p>A previously published job was edited by an employer and is <strong>pending approval</strong> again.</p>
    <p><strong>Company:</strong> {{ $job->company->name ?? '—' }}<br>
       <strong>Job:</strong> {{ $job->title }}</p>
    <p><a href="{{ route('admin.jobs.pending-company', absolute: true) }}" style="display:inline-block;padding:10px 16px;background:#2563eb;color:#fff;text-decoration:none;border-radius:6px;">Open pending employer jobs</a></p>
@else
    <p>Hello,</p>
    <p>You edited <strong>{{ $job->title }}</strong>. Because the listing content changed, it is <strong>pending approval</strong> and is no longer visible on the public site until an administrator publishes it again.</p>
    <p><a href="{{ route('company.dashboard', ['section' => 'my-jobs'], absolute: true) }}" style="display:inline-block;padding:10px 16px;background:#2563eb;color:#fff;text-decoration:none;border-radius:6px;">View my jobs</a></p>
@endif
    <p style="font-size:12px;color:#666;">{{ config('app.name') }}</p>
</body>
</html>
