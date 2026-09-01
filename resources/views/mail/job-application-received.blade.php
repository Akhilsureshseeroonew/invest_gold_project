New job application from the website
===================================

Role:     {{ $application->job_title }}
Name:     {{ $application->name }}
Phone:    {{ $application->phone }}
Email:    {{ $application->email }}
CV:       {{ $application->cv_name ?: '(not attached)' }}
Page:     {{ $application->source_url ?: '—' }}
Received: {{ $application->created_at->format('d M Y, H:i') }}

The CV is attached to this email.

--
Manage this application: {{ url('/admin/job-applications/'.$application->id.'/edit') }}
