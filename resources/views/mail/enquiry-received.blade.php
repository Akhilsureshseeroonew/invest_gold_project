New enquiry from the website
============================

Name:     {{ $enquiry->name }}
Phone:    {{ $enquiry->phone }}
Email:    {{ $enquiry->email }}
Service:  {{ $enquiry->service ?: '—' }}
Page:     {{ $enquiry->source_url ?: '—' }}
Received: {{ $enquiry->created_at->format('d M Y, H:i') }}

Message:
{{ $enquiry->message ?: '(none)' }}

--
Manage this enquiry: {{ url('/admin/enquiries/'.$enquiry->id.'/edit') }}
