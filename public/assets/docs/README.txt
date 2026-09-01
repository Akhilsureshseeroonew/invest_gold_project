Policy documents for policies.html
==================================

/assets/docs/            downloadable PDFs (rendered with a "Download" tag)
  fair-practice-code.pdf
  grievance-redressal-policy.pdf
  interest-rate-policy.pdf
  kyc-aml-policy.pdf
  gold-auction-policy.pdf
  privacy-policy.pdf
  kyc-document-checklist.pdf

/assets/docs/view/       view-only PDFs (open in the on-page viewer, no download offered)
  rbi-certificate-of-registration.pdf
  most-important-terms-and-conditions.pdf
  ombudsman-scheme-notice.pdf
  statutory-auditor-declaration.pdf
  grievance-escalation-matrix.pdf

Drop the real files in using these exact names and the page works as-is.
To rename one instead, update its href (downloads) or data-doc-src (view-only)
in policies.html, and the "PDF - nnn KB" size label next to it.

Note on the view-only set: the viewer hides the PDF toolbar so there is no obvious
save button, but the files are still served as static URLs and can be fetched
directly. If these must be genuinely restricted, move them outside the web root
and serve them through a script that checks the request before streaming the file.
