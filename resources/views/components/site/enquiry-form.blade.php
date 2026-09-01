@props(['service' => null])

@php
    $service ??= request('service');
    $services = [
        'Loans'       => ['Gold Loan', 'Personal Loan', 'Mahila Loan', 'Consumer Loan'],
        'Investments' => ['NCD Investment', 'SD Investment', 'Doubling Investment'],
        'Other'       => ['Mobile App Support', 'Careers', 'General Enquiry'],
    ];
    $done = session('enquiry_sent');
@endphp

<form class="enquiry__form" id="enquiryForm" method="post" action="{{ route('enquiry.store') }}"
      novalidate data-reveal="right">
    @csrf
    <input type="hidden" name="source_url" value="{{ url()->current() }}">

    <div class="form-grid">
        <div @class(['field', 'is-invalid' => $errors->has('name')])>
            <label for="fName">Name</label>
            <input class="input" type="text" id="fName" name="name" value="{{ old('name') }}"
                   placeholder="Your full name" autocomplete="name" required>
            <span class="err">{{ $errors->first('name') ?: 'Please enter your name.' }}</span>
        </div>
        <div @class(['field', 'is-invalid' => $errors->has('phone')])>
            <label for="fPhone">Phone number</label>
            <input class="input" type="tel" id="fPhone" name="phone" value="{{ old('phone') }}"
                   placeholder="10-digit mobile number" autocomplete="tel" inputmode="numeric" required>
            <span class="err">{{ $errors->first('phone') ?: 'Please enter a valid 10-digit number.' }}</span>
        </div>
        <div @class(['field', 'is-invalid' => $errors->has('email')])>
            <label for="fEmail">Email</label>
            <input class="input" type="email" id="fEmail" name="email" value="{{ old('email') }}"
                   placeholder="you@example.com" autocomplete="email" required>
            <span class="err">{{ $errors->first('email') ?: 'Please enter a valid email address.' }}</span>
        </div>
        <div @class(['field', 'is-invalid' => $errors->has('service')])>
            <label for="fService">Service</label>
            <select class="select" id="fService" name="service" required>
                <option value="">Select a service</option>
                @foreach ($services as $group => $options)
                    <optgroup label="{{ $group }}">
                        @foreach ($options as $option)
                            <option @selected(old('service', $service) === $option)>{{ $option }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            <span class="err">{{ $errors->first('service') ?: 'Please choose a service.' }}</span>
        </div>
        <div @class(['field', 'field--full', 'is-invalid' => $errors->has('message')])>
            <label for="fMessage">Message</label>
            <textarea class="textarea" id="fMessage" name="message" placeholder="Tell us how we can help…">{{ old('message') }}</textarea>
            <span class="err">{{ $errors->first('message') }}</span>
        </div>
    </div>

    <button class="btn btn--gold btn--block" type="submit" style="margin-top:1.3rem">
        Submit Enquiry <svg width="16" height="16"><use href="#i-arrow-right"/></svg>
    </button>

    <p class="form-note disclaimer">
        By submitting, you agree to be contacted by our team regarding your enquiry. We never share your details with third parties.
    </p>

    <div @class(['form-ok', 'is-shown' => $done]) id="formOk" role="status">
        <b>Thank you!</b> Your enquiry has been recorded. Our team will get in touch with you shortly.
    </div>
</form>
