@php
    $g = config('site.calculator');
    $emiRates = [
        'Personal Loan' => (float) config('site.calculator.personal_loan_rate', 16),
        'Mahila Loan'   => (float) config('site.calculator.mahila_loan_rate', 14),
        'Consumer Loan' => (float) config('site.calculator.consumer_loan_rate', 18),
    ];
@endphp

<div class="calc" id="calcHub"
     style="align-items:flex-start"
     data-emi-rates='@json($emiRates)'>
    <div class="calc__mascot" data-reveal="left" style="align-self:center">
        <div class="bubble" id="calcBubble">“Pick your loan type — <em>I’ll work out the numbers.</em>”</div>
        <img src="{{ asset('assets/img/mascot.png') }}" alt="Invest Gold mascot ready to calculate"
             loading="lazy" decoding="async" width="1355" height="1160">
    </div>

    <div class="calc__panel" data-reveal="right">
        <fieldset class="calc__types" id="calcLoanType"
                  style="margin-bottom:1.4rem;padding:0 0 1.2rem;border:0;border-bottom:1px solid var(--border-soft)">
            <legend style="font-size:1.05rem;font-weight:700;color:var(--text);padding:0;margin-bottom:.8rem">Loan type</legend>
            <div class="calc__types-row">
                @foreach (['gold' => 'Gold Loan', 'Personal Loan' => 'Personal Loan', 'Mahila Loan' => 'Mahila Loan', 'Consumer Loan' => 'Consumer Loan'] as $val => $label)
                    <label class="calc__type">
                        <input type="radio" name="calcLoanType" value="{{ $val }}" @checked($val === 'gold')>
                        <span>{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </fieldset>

      <div class="calc__modes" id="calcModes">
        {{-- ============ GOLD LOAN ============ --}}
        <div id="calcGold">
            <div class="switch" id="calcSwitch" data-mode="gold" role="tablist" aria-label="Calculator mode">
                <span class="switch__thumb" aria-hidden="true"></span>
                <button type="button" role="tab" aria-selected="true" data-mode="gold">Calculate by Gold Weight</button>
                <button type="button" role="tab" aria-selected="false" data-mode="cash">Calculate by Cash Needed</button>
            </div>

            <div id="paneGold">
                <div class="field">
                    <label for="gWeight">Gold weight (grams) <b id="gWeightOut">40 g</b></label>
                    <input type="range" id="gWeight" min="1" max="500" step="1" value="40">
                </div>
            </div>

            <div id="paneCash" hidden>
                <div class="field">
                    <label for="cAmount">Cash you need <b id="cAmountOut">₹2,00,000</b></label>
                    <input type="range" id="cAmount" min="10000" max="5000000" step="5000" value="200000">
                </div>
            </div>

            <div class="form-grid">
                <div class="field">
                    <label for="gPurity">Purity</label>
                    <select class="select" id="gPurity">
                        <option value="1">22K (916)</option>
                        <option value="1.0909">24K (999)</option>
                        <option value="0.9545">21K (875)</option>
                        <option value="0.8182">18K (750)</option>
                    </select>
                </div>
                <div class="field">
                    <label for="gRate">Rate per gram (22K)</label>
                    <input class="input" type="number" id="gRate" value="{{ $g['gold_rate_per_gram'] }}" min="1000" step="50" inputmode="numeric">
                </div>
                <div class="field">
                    <label for="gTenure">Tenure (months) <b id="gTenureOut">{{ $g['default_tenure_months'] }}</b></label>
                    <input type="range" id="gTenure" min="3" max="36" step="1" value="{{ $g['default_tenure_months'] }}">
                </div>
                <div class="field">
                    <label for="gInterest">Interest p.a. <b id="gInterestOut">{{ $g['default_interest_pa'] }}%</b></label>
                    <input type="range" id="gInterest" min="8" max="24" step="0.25" value="{{ $g['default_interest_pa'] }}">
                </div>
            </div>

            <div class="calc__result">
                <small id="resultLabel">Eligible loan amount</small>
                <div class="calc__amount" id="resultAmount">₹2,76,000</div>
                <div class="calc__meta">
                    <div><b id="metaA">₹3,68,000</b><span id="metaALabel">Gold value</span></div>
                    <div><b id="metaB">{{ $g['max_ltv_percent'] }}%</b><span>LTV applied</span></div>
                    <div><b id="metaC">₹24,540</b><span>Approx. EMI</span></div>
                </div>
            </div>
        </div>

        {{-- ============ EMI (personal / mahila / consumer) ============ --}}
        <div id="calcEmi" data-loan-calc hidden>
            <div class="field">
                <label for="lcAmount">Loan amount <b id="lcAmountOut">₹3,00,000</b></label>
                <input type="range" id="lcAmount" min="25000" max="2000000" step="5000" value="300000">
                <span class="disclaimer" id="lcAmountWords" style="margin-top:.35rem"></span>
            </div>
            <div class="form-grid">
                <div class="field">
                    <label for="lcAmountNum">Amount (₹)</label>
                    <input class="input" type="number" id="lcAmountNum" value="300000" min="25000" max="2000000" step="1000" inputmode="numeric">
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
                    <label for="lcRate">Interest p.a. <b id="lcRateOut">16.00%</b></label>
                    <input type="range" id="lcRate" min="11" max="28" step="0.25" value="16">
                </div>
                <div class="field">
                    <label for="lcTenure">Tenure <b id="lcTenureOut">24 months</b></label>
                    <input type="range" id="lcTenure" min="6" max="60" step="1" value="24">
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
            </div>
        </div>
      </div>{{-- /.calc__modes --}}

        <div style="display:flex;flex-wrap:wrap;gap:.7rem;margin-top:1.3rem">
            <a class="btn btn--gold btn--sm" id="calcEnquire" href="{{ url('/contact?service=Gold%20Loan') }}">
                Enquire Now <svg width="15" height="15"><use href="#i-arrow-right"/></svg>
            </a>
            <a class="btn btn--ghost btn--sm" href="{{ url('/branches') }}">Visit Nearest Branch</a>
        </div>

        <p class="disclaimer" data-ltv="{{ $g['max_ltv_percent'] }}" data-rate="{{ $g['gold_rate_per_gram'] }}">
            * Indicative estimate only. Gold loan eligibility depends on appraised purity, weight and the prevailing
            gold rate on the day of pledge; LTV is capped as per RBI norms. EMI figures use the reducing-balance method —
            actual rate, processing fee, GST and eligibility depend on your profile and are confirmed at the branch.
        </p>
    </div>
</div>

@once
@push('head')
<style>
    .calc__types-row { display: flex; flex-wrap: wrap; gap: .5rem; }
    .calc__type { position: relative; }
    .calc__type input {
        position: absolute; inset: 0; margin: 0; opacity: 0; cursor: pointer;
    }
    .calc__type span {
        display: block; padding: .55rem 1rem; border-radius: 999px;
        border: 1px solid var(--border-soft); background: var(--surface-2);
        font-size: .88rem; font-weight: 600; color: var(--muted);
        transition: border-color .2s var(--ease), background .2s var(--ease), color .2s var(--ease);
    }
    .calc__type input:checked + span {
        border-color: transparent; background: var(--grad-gold); color: var(--navy-900);
    }
    .calc__type input:focus-visible + span {
        outline: 2px solid var(--gold-400); outline-offset: 2px;
    }
    .calc__type:hover input:not(:checked) + span { border-color: var(--gold-400); color: var(--text); }
</style>
@endpush
@endonce

@once
@push('scripts')
<script>
/* EMI (reducing-balance) engine — shared for Personal / Mahila / Consumer loan modes */
(function () {
    var inr0 = new Intl.NumberFormat('en-IN', { maximumFractionDigits: 0 });
    var inr2 = new Intl.NumberFormat('en-IN', { maximumFractionDigits: 2 });
    function money(n) { return '₹' + inr0.format(Math.max(0, Math.round(n))); }
    function inWords(n) {
        n = Math.max(0, Math.round(n));
        if (n >= 10000000) return '₹' + inr2.format(n / 10000000) + ' Crore';
        if (n >= 100000)   return '₹' + inr2.format(n / 100000) + ' Lakh';
        if (n >= 1000)     return '₹' + inr2.format(n / 1000) + ' Thousand';
        return money(n);
    }

    document.querySelectorAll('[data-loan-calc]').forEach(function (root) {
        var q = function (id) { return root.querySelector('#' + id); };
        var amount = q('lcAmount'), amountNum = q('lcAmountNum'),
            rate = q('lcRate'), tenure = q('lcTenure'), freq = q('lcFreq');
        if (!amount || !rate || !tenure) return;

        var out = {
            amount: q('lcAmountOut'), amountWords: q('lcAmountWords'),
            rate: q('lcRateOut'), tenure: q('lcTenureOut'),
            emi: q('lcEmi'), label: q('lcResultLabel'),
            principal: q('lcPrincipal'), interest: q('lcInterest'), total: q('lcTotal')
        };

        function calc() {
            var P = Math.min(+amount.max, Math.max(+amount.min, +amount.value || 0));
            var annual = +rate.value, n = +tenure.value, r = annual / 12 / 100;
            var emiMonthly = r === 0 ? P / n : (P * r * Math.pow(1 + r, n)) / (Math.pow(1 + r, n) - 1);
            var totalPay = emiMonthly * n, totalInterest = totalPay - P;

            var perInstalment = emiMonthly, label = 'Monthly EMI';
            if (freq && freq.value === 'weekly') { perInstalment = emiMonthly * 12 / 52; label = 'Weekly instalment'; }
            else if (freq && freq.value === 'daily') { perInstalment = emiMonthly * 12 / 365; label = 'Daily instalment'; }

            out.amount.textContent = money(P);
            out.amountWords.textContent = inWords(P);
            out.rate.textContent = inr2.format(annual) + '%';
            out.tenure.textContent = n + (n === 1 ? ' month' : ' months');
            out.label.textContent = label;
            out.emi.textContent = money(perInstalment);
            out.principal.textContent = money(P);
            out.interest.textContent = money(totalInterest);
            out.total.textContent = money(totalPay);
        }

        amount.addEventListener('input', function () { if (amountNum) amountNum.value = amount.value; calc(); });
        if (amountNum) amountNum.addEventListener('input', function () {
            var v = Math.min(+amount.max, Math.max(+amount.min, +amountNum.value || 0));
            amount.value = v; calc();
        });
        [rate, tenure, freq].forEach(function (el) { if (el) el.addEventListener('input', calc); });

        root._recalc = calc;   // exposed so the loan-type switcher can re-run it
        calc();
    });

    /* Loan-type radio group: toggles the Gold panel vs the EMI panel and, for an
       unsecured loan, presets the EMI interest rate from Site Settings. */
    var hub = document.getElementById('calcHub');
    if (!hub) return;
    var group = document.getElementById('calcLoanType'),
        radios = group ? group.querySelectorAll('input[name="calcLoanType"]') : [],
        modes = document.getElementById('calcModes'),
        gold = document.getElementById('calcGold'),
        emi = document.getElementById('calcEmi'),
        enquire = document.getElementById('calcEnquire'),
        rateInput = emi && emi.querySelector('#lcRate'),
        rateOut = emi && emi.querySelector('#lcRateOut');
    var rates = {};
    try { rates = JSON.parse(hub.getAttribute('data-emi-rates') || '{}'); } catch (e) {}

    function selectedValue() {
        var c = group && group.querySelector('input[name="calcLoanType"]:checked');
        return c ? c.value : 'gold';
    }

    /* Reserve the height of the TALLER panel so switching loan type never
       changes the panel size — otherwise the browser's scroll-anchoring shoves
       the whole calculator up/down a few dozen px on every change. */
    function lockHeight() {
        var wasGold = gold.hidden, wasEmi = emi.hidden;
        modes.style.minHeight = '';
        gold.hidden = false; emi.hidden = true;
        var hGold = modes.offsetHeight;
        gold.hidden = true; emi.hidden = false;
        var hEmi = modes.offsetHeight;
        gold.hidden = wasGold; emi.hidden = wasEmi;
        modes.style.minHeight = Math.max(hGold, hEmi) + 'px';
    }

    var lastValue = null;
    function apply() {
        var v = selectedValue();
        if (v === lastValue) return;
        lastValue = v;
        var isGold = v === 'gold';
        gold.hidden = !isGold;
        emi.hidden = isGold;
        var service = isGold ? 'Gold Loan' : v;
        if (enquire) enquire.href = '/contact?service=' + encodeURIComponent(service);
        if (!isGold && rateInput && rates[v] != null) {
            rateInput.value = rates[v];
            if (rateOut) rateOut.textContent = Number(rates[v]).toFixed(2) + '%';
            if (emi._recalc) emi._recalc();
        }
    }

    if (radios.length) {
        lockHeight();
        apply();
        radios.forEach(function (r) { r.addEventListener('change', apply); });
        var t;
        window.addEventListener('resize', function () {
            clearTimeout(t);
            t = setTimeout(lockHeight, 200);
        });
    }
})();
</script>
@endpush
@endonce
