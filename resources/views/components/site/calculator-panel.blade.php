@php $calc = config('site.calculator'); @endphp

<div class="calc">
    <div class="calc__mascot" data-reveal="left">
        <div class="bubble" id="calcBubble">“How much gold do you have today? <em>Let me calculate for you.</em>”</div>
        <img src="{{ asset('assets/img/mascot.png') }}" alt="Invest Gold mascot ready to calculate" loading="lazy" decoding="async" width="1355" height="1160">
    </div>

    <div class="calc__panel" data-reveal="right">
        <div style="margin-bottom:1.4rem;padding-bottom:1rem;border-bottom:1px solid var(--border-soft)">
            <b style="display:block;font-size:1.15rem">Gold Loan Calculator</b>
            <span class="disclaimer" style="margin:0">Estimate the loan your gold can secure</span>
        </div>

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
                <input class="input" type="number" id="gRate" value="{{ $calc['gold_rate_per_gram'] }}" min="1000" step="50" inputmode="numeric">
            </div>
            <div class="field">
                <label for="gTenure">Tenure (months) <b id="gTenureOut">{{ $calc['default_tenure_months'] }}</b></label>
                <input type="range" id="gTenure" min="3" max="36" step="1" value="{{ $calc['default_tenure_months'] }}">
            </div>
            <div class="field">
                <label for="gInterest">Interest p.a. <b id="gInterestOut">{{ $calc['default_interest_pa'] }}%</b></label>
                <input type="range" id="gInterest" min="8" max="24" step="0.25" value="{{ $calc['default_interest_pa'] }}">
            </div>
        </div>

        <div class="calc__result">
            <small id="resultLabel">Eligible loan amount</small>
            <div class="calc__amount" id="resultAmount">₹2,76,000</div>
            <div class="calc__meta">
                <div><b id="metaA">₹3,68,000</b><span id="metaALabel">Gold value</span></div>
                <div><b id="metaB">{{ $calc['max_ltv_percent'] }}%</b><span>LTV applied</span></div>
                <div><b id="metaC">₹24,540</b><span>Approx. EMI</span></div>
            </div>
            <div style="display:flex;flex-wrap:wrap;gap:.7rem;margin-top:1.3rem">
                <a class="btn btn--gold btn--sm" href="{{ url('/contact?service=Gold%20Loan') }}">Enquire Now <svg width="15" height="15"><use href="#i-arrow-right"/></svg></a>
                <a class="btn btn--ghost btn--sm" href="{{ url('/branches') }}">Visit Nearest Branch</a>
            </div>
        </div>

        <p class="disclaimer" data-ltv="{{ $calc['max_ltv_percent'] }}" data-rate="{{ $calc['gold_rate_per_gram'] }}">
            * Indicative estimate only. Actual eligibility depends on appraised purity, weight, the prevailing
            gold rate on the day of pledge and applicable scheme terms. Loan-to-value is capped as per RBI norms.
            Interest rate slabs may apply retrospectively from the pledge date — please confirm final figures at a branch.
        </p>
    </div>
</div>
