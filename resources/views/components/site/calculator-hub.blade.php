@php
    $g = config('site.calculator');
    $emiRates = [
        'Personal Loan' => (float) ($g['personal_loan_rate'] ?? 16),
        'Mahila Loan'   => (float) ($g['mahila_loan_rate'] ?? 14),
        'Consumer Loan' => (float) ($g['consumer_loan_rate'] ?? 18),
    ];
    $investRates = [
        'NCD'               => ['rate' => (float) ($g['ncd_rate'] ?? 10)],
        'Subordinated Debt' => ['rate' => (float) ($g['subordinated_debt_rate'] ?? 11)],
        'Doubling Sub-Debt' => ['double' => true, 'years' => (int) ($g['doubling_years'] ?? 7)],
    ];
    $goldRates = [
        '24' => (int) ($g['gold_rate_24k'] ?? 10040),
        '22' => (int) ($g['gold_rate_22k'] ?? 9200),
        '21' => (int) ($g['gold_rate_21k'] ?? 8790),
        '18' => (int) ($g['gold_rate_18k'] ?? 7530),
    ];
@endphp

<div class="calc" id="calcHub"
     style="align-items:flex-start"
     data-emi-rates='@json($emiRates)'
     data-invest-rates='@json($investRates)'>
    <div class="calc__mascot" data-reveal="left" style="align-self:center">
        <div class="bubble" id="calcBubble">“How much gold do you have today? <em>Let me calculate for you.</em>”</div>
        <img src="{{ asset('assets/img/mascot.png') }}" alt="Invest Gold mascot ready to calculate"
             loading="lazy" decoding="async" width="1355" height="1160">
    </div>

    <div class="calc__panel" data-reveal="right">
        <fieldset class="calc__types" id="calcLoanType"
                  style="margin-bottom:1.4rem;padding:0 0 1.2rem;border:0;border-bottom:1px solid var(--border-soft)">
            <legend style="font-size:1.05rem;font-weight:700;color:var(--text);padding:0;margin-bottom:.8rem">Product</legend>
            <div class="calc__types-row">
                @foreach ([
                    'gold' => 'Gold Loan',
                    'Personal Loan' => 'Personal Loan', 'Mahila Loan' => 'Mahila Loan', 'Consumer Loan' => 'Consumer Loan',
                    'NCD' => 'NCD', 'Subordinated Debt' => 'Subordinated Debt', 'Doubling Sub-Debt' => 'Doubling Sub-Debt',
                ] as $val => $label)
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
                    <select class="select" id="gPurity" data-gold-rates='@json($goldRates)'>
                        <option value="{{ $goldRates['24'] }}">24K (999)</option>
                        <option value="{{ $goldRates['22'] }}" selected>22K (916)</option>
                        <option value="{{ $goldRates['21'] }}">21K (875)</option>
                        <option value="{{ $goldRates['18'] }}">18K (750)</option>
                    </select>
                </div>
                <div class="field">
                    <label for="gRate">Rate per gram <b id="gRateKarat">22K</b></label>
                    <input class="input calc__ratefixed" type="text" id="gRate"
                           value="₹{{ number_format($goldRates['22']) }}"
                           data-rate="{{ $goldRates['22'] }}"
                           readonly aria-readonly="true" tabindex="-1">
                    <span class="disclaimer" style="margin-top:.35rem">Today's published Invest Gold rate — set by the branch</span>
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
                    <div><b id="metaC">₹0</b><span id="metaCLabel">Total interest</span></div>
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

        {{-- ============ INVESTMENT (NCD / Subordinated Debt / Doubling Sub-Debt) ============ --}}
        <div id="calcInvest" data-invest-calc hidden>
            <div class="field">
                <label for="invAmount">Investment amount <b id="invAmountOut">₹2,00,000</b></label>
                <input type="range" id="invAmount" min="10000" max="10000000" step="5000" value="200000">
                <span class="disclaimer" id="invAmountWords" style="margin-top:.35rem"></span>
            </div>
            <div class="form-grid">
                <div class="field">
                    <label for="invAmountNum">Amount (₹)</label>
                    <input class="input" type="number" id="invAmountNum" value="200000" min="10000" max="10000000" step="1000" inputmode="numeric">
                </div>
                <div class="field" id="invTenureField">
                    <label for="invTenure">Term (years) <b id="invTenureOut">5 years</b></label>
                    <input type="range" id="invTenure" min="1" max="10" step="1" value="5">
                </div>
            </div>

            <div class="calc__result">
                <small id="invResultLabel">Maturity amount</small>
                <div class="calc__amount" id="invMaturity">₹0</div>
                <div class="calc__meta">
                    <div><b id="invRate">10%</b><span>Applicable interest p.a.</span></div>
                    <div><b id="invInterest">₹0</b><span>Interest earned</span></div>
                    <div><b id="invTerm">5 yrs</b><span>Term</span></div>
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

        <p class="disclaimer" data-ltv="{{ $g['max_ltv_percent'] }}" data-rate="{{ $goldRates['22'] }}">
            * Indicative estimate only. Gold loan eligibility depends on appraised purity, weight and the prevailing
            gold rate on the day of pledge; LTV is capped as per RBI norms. EMI figures use the reducing-balance method.
            Investment returns are shown compounded yearly and are indicative — actual rates, tenure slabs and terms
            are per the scheme documents and confirmed at the branch.
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

    /* rate/gram is admin-controlled — shown, not editable */
    .calc__ratefixed {
        cursor: default;
        color: var(--gold-ink);
        font-weight: 700;
        background: var(--surface-2);
    }
    .calc__ratefixed:focus { outline: none; box-shadow: none; border-color: var(--border-soft); }
</style>
@endpush
@endonce

@once
@push('scripts')
<script>
(function () {
    var inr0 = new Intl.NumberFormat('en-IN', { maximumFractionDigits: 0 });
    var inr2 = new Intl.NumberFormat('en-IN', { maximumFractionDigits: 2 });
    function money(n) { return '₹' + inr0.format(Math.max(0, Math.round(n))); }
    function pct(n) { return inr2.format(n).replace(/\.00$/, '') + '%'; }
    function inWords(n) {
        n = Math.max(0, Math.round(n));
        if (n >= 10000000) return '₹' + inr2.format(n / 10000000) + ' Crore';
        if (n >= 100000)   return '₹' + inr2.format(n / 100000) + ' Lakh';
        if (n >= 1000)     return '₹' + inr2.format(n / 1000) + ' Thousand';
        return money(n);
    }
    // fill the "played" portion of a range track (same visual as the gold calc)
    function paintRange(input) {
        if (!input) return;
        var min = parseFloat(input.min), max = parseFloat(input.max);
        var p = max > min ? ((parseFloat(input.value) - min) / (max - min)) * 100 : 0;
        input.style.setProperty('--fill', Math.max(0, Math.min(100, p)) + '%');
    }
    function bound(range, raw) {
        return Math.min(+range.max, Math.max(+range.min, +raw || 0));
    }

    /* ---------- Gold: mirror the selected karat's admin rate into the read-only field ----------
       (the gold engine in main.js §07 recomputes from #gPurity's own change event) */
    (function () {
        var purity = document.getElementById('gPurity'),
            rateOut = document.getElementById('gRate'),
            karatOut = document.getElementById('gRateKarat');
        if (!purity || !rateOut) return;
        function sync() {
            var opt = purity.options[purity.selectedIndex];
            var v = parseInt(opt.value, 10) || 0;
            rateOut.value = '₹' + inr0.format(v);
            rateOut.dataset.rate = v;
            if (karatOut) karatOut.textContent = (opt.textContent.split(' ')[0] || '');
        }
        purity.addEventListener('change', sync);
        sync();
    })();

    /* ---------- EMI engine (Personal / Mahila / Consumer) ---------- */
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
            var P = bound(amount, amount.value);
            var annual = +rate.value, n = +tenure.value, r = annual / 12 / 100;
            var emiMonthly = r === 0 ? P / n : (P * r * Math.pow(1 + r, n)) / (Math.pow(1 + r, n) - 1);
            var totalPay = emiMonthly * n, totalInterest = totalPay - P;

            var perInstalment = emiMonthly, label = 'Monthly EMI';
            if (freq && freq.value === 'weekly') { perInstalment = emiMonthly * 12 / 52; label = 'Weekly instalment'; }
            else if (freq && freq.value === 'daily') { perInstalment = emiMonthly * 12 / 365; label = 'Daily instalment'; }

            [amount, rate, tenure].forEach(paintRange);
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
        if (amountNum) amountNum.addEventListener('input', function () { amount.value = bound(amount, amountNum.value); calc(); });
        [rate, tenure, freq].forEach(function (el) { if (el) el.addEventListener('input', calc); });

        root._recalc = calc;
        calc();
    });

    /* ---------- Investment engine (NCD / Subordinated Debt / Doubling Sub-Debt) ---------- */
    document.querySelectorAll('[data-invest-calc]').forEach(function (root) {
        var q = function (id) { return root.querySelector('#' + id); };
        var amount = q('invAmount'), amountNum = q('invAmountNum'),
            tenure = q('invTenure'), tenureField = q('invTenureField');
        if (!amount || !tenure) return;

        var out = {
            amount: q('invAmountOut'), words: q('invAmountWords'), maturity: q('invMaturity'),
            label: q('invResultLabel'), rate: q('invRate'), interest: q('invInterest'),
            term: q('invTerm'), tenureOut: q('invTenureOut')
        };
        var product = { double: false, rate: 10, years: 7 };

        function calc() {
            var P = bound(amount, amount.value);
            var years, maturity, interest, rateShown;
            if (product.double) {
                years = product.years;
                maturity = P * 2;
                interest = P;
                rateShown = (Math.pow(2, 1 / years) - 1) * 100;
                out.label.textContent = 'Return at maturity (2×)';
            } else {
                years = +tenure.value;
                rateShown = product.rate;
                maturity = P * Math.pow(1 + rateShown / 100, years);
                interest = maturity - P;
                out.label.textContent = 'Maturity amount';
            }
            paintRange(amount);
            if (!product.double) paintRange(tenure);
            out.amount.textContent = money(P);
            out.words.textContent = inWords(P);
            out.maturity.textContent = money(maturity);
            out.rate.textContent = pct(rateShown);
            out.interest.textContent = money(interest);
            var termTxt = years + (years === 1 ? ' year' : ' years');
            out.term.textContent = termTxt;
            if (out.tenureOut) out.tenureOut.textContent = termTxt;
        }

        amount.addEventListener('input', function () { if (amountNum) amountNum.value = amount.value; calc(); });
        if (amountNum) amountNum.addEventListener('input', function () { amount.value = bound(amount, amountNum.value); calc(); });
        tenure.addEventListener('input', calc);

        root._recalc = calc;
        root._setProduct = function (p) {
            product = p;
            if (tenureField) tenureField.style.display = p.double ? 'none' : '';
            calc();
        };
        calc();
    });

    /* ---------- Product radio group: gold / EMI / investment ---------- */
    var hub = document.getElementById('calcHub');
    if (!hub) return;
    var group = document.getElementById('calcLoanType'),
        radios = group ? group.querySelectorAll('input[name="calcLoanType"]') : [],
        modes = document.getElementById('calcModes'),
        gold = document.getElementById('calcGold'),
        emi = document.getElementById('calcEmi'),
        invest = document.getElementById('calcInvest'),
        enquire = document.getElementById('calcEnquire'),
        bubble = document.getElementById('calcBubble'),
        rateInput = emi && emi.querySelector('#lcRate'),
        rateOut = emi && emi.querySelector('#lcRateOut');

    var BUBBLE = {
        gold:   '“How much gold do you have today? <em>Let me calculate for you.</em>”',
        emi:    '“How much do you want to borrow? <em>Let me work out your EMI.</em>”',
        invest: '“How much would you like to invest? <em>Let me show you the returns.</em>”'
    };

    var emiRates = {}, investRates = {};
    try { emiRates = JSON.parse(hub.getAttribute('data-emi-rates') || '{}'); } catch (e) {}
    try { investRates = JSON.parse(hub.getAttribute('data-invest-rates') || '{}'); } catch (e) {}

    var SERVICE = {
        'gold': 'Gold Loan',
        'NCD': 'NCD Investment',
        'Subordinated Debt': 'SD Investment',
        'Doubling Sub-Debt': 'Doubling Investment'
    };

    function selectedValue() {
        var c = group && group.querySelector('input[name="calcLoanType"]:checked');
        return c ? c.value : 'gold';
    }
    function modeOf(v) {
        if (v === 'gold') return 'gold';
        if (emiRates[v] != null) return 'emi';
        if (investRates[v] != null) return 'invest';
        return 'gold';
    }

    var lastValue = null;
    function apply() {
        var v = selectedValue();
        if (v === lastValue) return;
        lastValue = v;
        var mode = modeOf(v);

        gold.hidden = mode !== 'gold';
        emi.hidden = mode !== 'emi';
        if (invest) invest.hidden = mode !== 'invest';

        if (bubble && BUBBLE[mode]) bubble.innerHTML = BUBBLE[mode];
        if (enquire) enquire.href = '/contact?service=' + encodeURIComponent(SERVICE[v] || v);

        if (mode === 'emi' && rateInput && emiRates[v] != null) {
            rateInput.value = emiRates[v];
            if (rateOut) rateOut.textContent = Number(emiRates[v]).toFixed(2) + '%';
            if (emi._recalc) emi._recalc();
        }
        if (mode === 'invest' && invest && invest._setProduct) {
            var d = investRates[v] || {};
            invest._setProduct(d.double
                ? { double: true, years: d.years || 7 }
                : { double: false, rate: d.rate != null ? d.rate : 10 });
        }
    }

    if (radios.length) {
        apply();
        radios.forEach(function (r) { r.addEventListener('change', apply); });
    }
})();
</script>
@endpush
@endonce
