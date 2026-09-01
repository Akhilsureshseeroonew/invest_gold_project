@props([
    'title' => 'Personal Loan',
    'service' => null,
    'rate' => 16,          // default interest % p.a. (reducing balance)
    'amount' => 300000,    // default loan amount (₹)
    'tenure' => 24,        // default tenure (months)
    'minAmount' => 25000,
    'maxAmount' => 2000000,
    'minRate' => 11,
    'maxRate' => 28,
    'minTenure' => 6,
    'maxTenure' => 60,
])
@php $service ??= $title; @endphp

<div class="calc" data-loan-calc>
    <div class="calc__mascot" data-reveal="left">
        <div class="bubble">“Tell me the amount and tenure — <em>I’ll work out your EMI.</em>”</div>
        <img src="{{ asset('assets/img/mascot.png') }}" alt="Invest Gold mascot ready to calculate" loading="lazy" decoding="async" width="1355" height="1160">
    </div>

    <div class="calc__panel" data-reveal="right">
        <div style="margin-bottom:1.4rem;padding-bottom:1rem;border-bottom:1px solid var(--border-soft)">
            <b style="display:block;font-size:1.15rem">{{ $title }} EMI Calculator</b>
            <span class="disclaimer" style="margin:0">Monthly EMI on a reducing-balance basis</span>
        </div>

        <div class="field">
            <label for="lcAmount">Loan amount <b id="lcAmountOut">₹3,00,000</b></label>
            <input type="range" id="lcAmount" min="{{ $minAmount }}" max="{{ $maxAmount }}" step="5000" value="{{ $amount }}">
            <span class="disclaimer" id="lcAmountWords" style="margin-top:.35rem"></span>
        </div>

        <div class="form-grid">
            <div class="field">
                <label for="lcAmountNum">Amount (₹)</label>
                <input class="input" type="number" id="lcAmountNum" value="{{ $amount }}" min="{{ $minAmount }}" max="{{ $maxAmount }}" step="1000" inputmode="numeric">
            </div>
            <div class="field">
                <label for="lcFreq">Repayment</label>
                <select class="select" id="lcFreq">
                    <option value="monthly" selected>Monthly EMI</option>
                    <option value="weekly">Weekly instalment</option>
                    <option value="daily">Daily instalment</option>
                </select>
            </div>
            <div class="field">
                <label for="lcRate">Interest p.a. <b id="lcRateOut">{{ number_format($rate, 2) }}%</b></label>
                <input type="range" id="lcRate" min="{{ $minRate }}" max="{{ $maxRate }}" step="0.25" value="{{ $rate }}">
            </div>
            <div class="field">
                <label for="lcTenure">Tenure <b id="lcTenureOut">{{ $tenure }} months</b></label>
                <input type="range" id="lcTenure" min="{{ $minTenure }}" max="{{ $maxTenure }}" step="1" value="{{ $tenure }}">
            </div>
        </div>

        <div class="calc__result">
            <small id="lcResultLabel">Monthly EMI</small>
            <div class="calc__amount" id="lcEmi">₹0</div>
            <div class="calc__meta">
                <div><b id="lcPrincipal">₹0</b><span>Principal</span></div>
                <div><b id="lcInterest">₹0</b><span>Total interest</span></div>
                <div><b id="lcTotal">₹0</b><span>Total payable</span></div>
            </div>
            <div style="display:flex;flex-wrap:wrap;gap:.7rem;margin-top:1.3rem">
                <a class="btn btn--gold btn--sm" href="{{ url('/contact?service='.rawurlencode($service)) }}">Enquire Now <svg width="15" height="15"><use href="#i-arrow-right"/></svg></a>
                <a class="btn btn--ghost btn--sm" href="{{ url('/branches') }}">Visit Nearest Branch</a>
            </div>
        </div>

        <p class="disclaimer">
            * Indicative EMI on a reducing-balance basis. Actual rate, processing fee, GST and eligibility
            depend on your income, credit profile and documentation, and are confirmed at the branch.
            Weekly and daily figures are the monthly EMI split across the period.
        </p>
    </div>
</div>

@once
@push('scripts')
<script>
(function () {
    var inr0 = new Intl.NumberFormat('en-IN', { maximumFractionDigits: 0 });
    var inr2 = new Intl.NumberFormat('en-IN', { maximumFractionDigits: 2 });
    function money(n) { return '₹' + inr0.format(Math.max(0, Math.round(n))); }

    // Indian short form: 5,00,000 -> "₹5.00 Lakh", 2,50,00,000 -> "₹2.50 Crore"
    function inWords(n) {
        n = Math.max(0, Math.round(n));
        if (n >= 10000000) return '₹' + inr2.format(n / 10000000) + ' Crore';
        if (n >= 100000)   return '₹' + inr2.format(n / 100000) + ' Lakh';
        if (n >= 1000)     return '₹' + inr2.format(n / 1000) + ' Thousand';
        return money(n);
    }

    document.querySelectorAll('[data-loan-calc]').forEach(function (root) {
        var $ = function (id) { return root.querySelector('#' + id); };
        var amount = $('lcAmount'), amountNum = $('lcAmountNum'),
            rate = $('lcRate'), tenure = $('lcTenure'), freq = $('lcFreq');
        if (!amount || !rate || !tenure) return;

        var out = {
            amount: $('lcAmountOut'), amountWords: $('lcAmountWords'),
            rate: $('lcRateOut'), tenure: $('lcTenureOut'),
            emi: $('lcEmi'), label: $('lcResultLabel'),
            principal: $('lcPrincipal'), interest: $('lcInterest'), total: $('lcTotal')
        };

        function calc() {
            var P = Math.min(+amount.max, Math.max(+amount.min, +amount.value || 0));
            var annual = +rate.value;
            var n = +tenure.value;               // months
            var r = annual / 12 / 100;           // monthly rate

            var emiMonthly = r === 0 ? P / n : (P * r * Math.pow(1 + r, n)) / (Math.pow(1 + r, n) - 1);
            var totalPay = emiMonthly * n;
            var totalInterest = totalPay - P;

            var perInstalment = emiMonthly, label = 'Monthly EMI';
            if (freq && freq.value === 'weekly') { perInstalment = emiMonthly * 12 / 52; label = 'Weekly instalment'; }
            else if (freq && freq.value === 'daily') { perInstalment = emiMonthly * 12 / 365; label = 'Daily instalment'; }

            out.amount.textContent = money(P);
            out.amountWords.textContent = inWords(P);
            out.rate.textContent = inr2.format(annual) + '%';
            out.tenure.textContent = n + (n === 1 ? ' month' : ' months');

            out.label.textContent = label;
            out.emi.textContent = money(perInstalment) + (freq && freq.value !== 'monthly' ? '' : '');
            out.principal.textContent = money(P);
            out.interest.textContent = money(totalInterest);
            out.total.textContent = money(totalPay);
        }

        // keep slider <-> number field in sync
        amount.addEventListener('input', function () { if (amountNum) amountNum.value = amount.value; calc(); });
        if (amountNum) amountNum.addEventListener('input', function () {
            var v = Math.min(+amount.max, Math.max(+amount.min, +amountNum.value || 0));
            amount.value = v; calc();
        });
        [rate, tenure, freq].forEach(function (el) { if (el) el.addEventListener('input', calc); });

        calc();
    });
})();
</script>
@endpush
@endonce
