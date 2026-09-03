@extends('layouts.site')

@section('title', ($page->seo_title ?? null) ?: "Invest Gold General Finance | Kerala's Trusted NBFC Since 1996")
@section('meta_description', ($page->seo_description ?? null) ?: "Kerala's trusted, RBI-registered NBFC since 1996. Instant gold, personal, Mahila & consumer loans - trusted by 10,000+ customers.")
@section('meta_keywords', 'gold loan Kerala, personal loan Thrissur, Mahila loan, consumer loan, NCD investment, subordinated debt, NBFC Kerala')



@section('content')
      <!-- ================= 03. HERO ================= -->
      <section class="hero" id="home">
        <video
          class="hero__video"
          autoplay
          muted
          loop
          playsinline
          preload="auto"
          poster="{{ asset('assets/img/mascot.png') }}"
          aria-hidden="true"
        >
          <source src="{{ asset('assets/video/ig-hero.mp4') }}" type="video/mp4" />
        </video>
        <div class="hero__video-overlay" aria-hidden="true"></div>
        <div class="container hero__inner">
          <div class="hero__copy">
            <span class="eyebrow" data-reveal
              >RBI Registered NBFC · Since 1996</span
            >
            <h1 data-reveal>
              Kerala's Trusted <span class="gold-text">Gold Loan</span> &amp;
              Finance Partner Since 1996
            </h1>
            <p class="hero__lead" data-reveal>
              Instant gold, personal, consumer &amp; Mahila loans at attractive
              rates, minimal paperwork — trusted by 10,000+ customers across
              Kerala.
            </p>

            <div class="hero__cta" data-reveal>
              <a class="btn btn--gold" href="/contact"
                >Apply Now
                <svg width="16" height="16"><use href="#i-arrow-right" /></svg
              ></a>
              <a class="btn btn--ghost" href="/products"
                >Explore Services</a
              >
            </div>
          </div>

          <!-- Mascot medallion + orbiting product badges (hosts the supplied 1.3s loop artwork) -->
          <div class="hero__visual" data-reveal="zoom">
            <div class="orbit">
              <svg class="orbit__web" viewBox="0 0 400 400" aria-hidden="true">
                <defs>
                  <linearGradient id="orbitLine" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#D4AF37" stop-opacity="0" />
                    <stop
                      offset="35%"
                      stop-color="#F2DFA0"
                      stop-opacity=".85"
                    />
                    <stop
                      offset="65%"
                      stop-color="#D4AF37"
                      stop-opacity=".55"
                    />
                    <stop offset="100%" stop-color="#A87F16" stop-opacity="0" />
                  </linearGradient>
                </defs>
                <circle
                  class="orbit__ring-solid"
                  cx="200"
                  cy="200"
                  r="168"
                  fill="none"
                  stroke="url(#orbitLine)"
                  stroke-width="1.4"
                />
                <circle
                  class="orbit__ring-dash"
                  cx="200"
                  cy="200"
                  r="168"
                  fill="none"
                  stroke="url(#orbitLine)"
                  stroke-width="2.6"
                  stroke-dasharray="3 16"
                  stroke-linecap="round"
                />
              </svg>

              <div class="medallion">
                <div class="medallion__frame">
                  <img
                    class="medallion__img"
                    src="{{ asset('assets/img/mascot.png') }}"
                    width="1355"
                    height="1160"
                    alt="Invest Gold royal elephant mascot holding a gold IG coin"
                    fetchpriority="high"
                    decoding="async"
                  />
                </div>
                <span class="medallion__shine" aria-hidden="true"></span>
                
              </div>

              <div class="orbit__items">
                <a
                  class="orbit__item"
                  style="--x: 11.9%; --y: 32.2%"
                  href="/products/gold-loan"
                >
                  <span class="orbit__disc"
                    ><svg><use href="#i-coin" /></svg
                  ></span>
                  <span class="orbit__label"
                    >Gold
                    Loan</span
                  >
                </a>
                <a
                  class="orbit__item"
                  style="--x: 88.1%; --y: 32.2%"
                  href="/products/personal-loan"
                >
                  <span class="orbit__disc"
                    ><svg><use href="#i-wallet" /></svg
                  ></span>
                  <span class="orbit__label"
                    >Personal Loan</span
                  >
                </a>
                <a
                  class="orbit__item"
                  style="--x: 15.6%; --y: 74.1%"
                  href="/products/consumer-loan"
                >
                  <span class="orbit__disc"
                    ><svg><use href="#i-tv" /></svg
                  ></span>
                  <span class="orbit__label"
                    >Consumer Loan</span
                  >
                </a>
                <a
                  class="orbit__item"
                  style="--x: 84.4%; --y: 74.1%"
                  href="/products/mahila-loan"
                >
                  <span class="orbit__disc"
                    ><svg><use href="#i-female" /></svg
                  ></span>
                  <span class="orbit__label"
                    >Mahila Loan</span
                  >
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- trust marquee -->
      <div class="marquee" aria-hidden="true">
        <div class="marquee__track">
          <span>Gold Loan</span><span>Personal Loan</span
          ><span>Mahila Loan</span><span>Consumer Loan</span>
          <span>NCD Investment</span><span>Subordinated Debt</span
          ><span>Doubling Scheme</span><span>Live Passbook</span>
          <span>Gold Loan</span><span>Personal Loan</span
          ><span>Mahila Loan</span><span>Consumer Loan</span>
          <span>NCD Investment</span><span>Subordinated Debt</span
          ><span>Doubling Scheme</span><span>Live Passbook</span>
        </div>
      </div>

      <!-- ================= 04. ABOUT ================= -->
      <section class="section" id="about">
        <div class="container">
          <div class="section-head" data-reveal>
            <h2>
              Empowering Financial Futures
              <span class="gold-text">Since 1996</span>
            </h2>
            <div class="divider" aria-hidden="true">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="132"
                height="14"
                viewBox="0 0 132 14"
                fill="none"
              >
                <path
                  d="M2 7H46M86 7H130"
                  stroke="#D4AF37"
                  stroke-width="1.3"
                />
                <path d="M66 2L72 7L66 12L60 7L66 2Z" fill="#D4AF37" />
                <path
                  d="M52 9C53.1046 9 54 8.10457 54 7C54 5.89543 53.1046 5 52 5C50.8954 5 50 5.89543 50 7C50 8.10457 50.8954 9 52 9Z"
                  stroke="#D4AF37"
                  stroke-width="1.3"
                />
                <path
                  d="M80 9C81.1046 9 82 8.10457 82 7C82 5.89543 81.1046 5 80 5C78.8954 5 78 5.89543 78 7C78 8.10457 78.8954 9 80 9Z"
                  stroke="#D4AF37"
                  stroke-width="1.3"
                />
              </svg>
            </div>
          </div>

          <div class="about__intro" data-reveal>
            <p>
              Invest Gold &amp; General Finance Pvt. Ltd. began in 1996 in
              Urakam, Thrissur, founded by a group of entrepreneurs with roots
              in Kerala's lending and chit fund sectors. Originally established
              as Invest Chit &amp; General Finance, the company received its
              NBFC certification from the Reserve Bank of India in 2001 — a
              turning point that shifted our focus entirely to lending.
            </p>
            <p>
              What started as a single office serving the Thrissur community has
              grown into a trusted financial partner for families across Kerala
              — offering gold loans, personal loans, Mahila loans, consumer
              loans, and fixed-return investment options like NCDs and
              Subordinated Debts.
            </p>
            <a
              class="btn btn--gold"
              href="https://wa.me/{{ config('site.whatsapp') }}"
              target="_blank"
              rel="noopener"
            >
              Talk to Our Team
            </a>
          </div>

          <div class="about__cards" data-reveal>
            <div class="card">
              <div class="card-icon">
                <svg><use href="#i-trend" /></svg>
              </div>
              <h3>Our Vision</h3>
              <p>
                A future where financial empowerment transforms lives and
                communities.
              </p>
            </div>
            <div class="card">
              <div class="card-icon">
                <svg><use href="#i-female" /></svg>
              </div>
              <h3>Our Mission</h3>
              <p>
                To empower women and farmers with innovative financial solutions
                that promote independence and sustainable growth.
              </p>
            </div>
            <div class="card">
              <div class="card-icon">
                <svg><use href="#i-award" /></svg>
              </div>
              <h3>How We Work</h3>
              <p>
                No one-size-fits-all products. We take time to understand what
                each customer actually needs before guiding them through a
                simple, transparent process — clear terms, no hidden charges,
                strict RBI compliance.
              </p>
            </div>
          </div>

          <!-- Invest Gold by the numbers -->
          <div class="stats-band" data-reveal>
          <div class="stats">
            <div class="stat" data-reveal="zoom">
              <b class="gold-text"><span data-count="10000">0</span>+</b
              ><span>Customers Served</span>
            </div>
            <div class="stat" data-reveal="zoom">
              <b class="gold-text"><span data-count="30">0</span>+</b
              ><span>Years in Kerala</span>
            </div>
            <div class="stat" data-reveal="zoom">
              <b class="gold-text"><span data-count="2001">0</span></b
              ><span>RBI Certified</span>
            </div>
          </div>
          </div>
        </div>
      </section>

      <!-- ================= 05. PRODUCTS ================= -->
      <section class="section section--alt" id="products">
        <div class="container">
          <div class="section-head" data-reveal>
            <span class="eyebrow">What We Offer</span>
            <h2>
              Products Built Around <span class="gold-text">Real Life</span>
            </h2>
            <p>
              Four lending products, one trusted partner — each with flexible
              eligibility, minimal paperwork and competitive rates.
            </p>
          </div>

          <div class="grid grid--4">
            <!-- Gold Loan -->
            <article class="card product" data-reveal="zoom" data-tilt>
              <span class="ribbon">Popular</span>
              <div class="card-icon">
                <svg><use href="#i-coin" /></svg>
              </div>
              <h3>Gold Loan</h3>
              <div class="product__sub">Quick Cash Against Your Gold</div>
              <p>
                Unlock the value of your gold jewellery with a secure,
                hassle-free gold loan. Attractive interest rates and flexible
                repayment options.
              </p>
              <a class="link-arrow" href="/products/gold-loan"
                >Explore Gold Loan
                <svg width="15" height="15"><use href="#i-arrow-right" /></svg
              ></a>
            </article>

            <!-- Personal Loan -->
            <article class="card product" data-reveal="zoom" data-tilt>
              <div class="card-icon">
                <svg><use href="#i-wallet" /></svg>
              </div>
              <h3>Personal Loan</h3>
              <div class="product__sub">
                Fast, Flexible, For Every Life Goal
              </div>
              <p>
                A medical emergency, a wedding or a home renovation — quick
                approval, minimal documentation and repayment plans that fit
                your budget.
              </p>
              <a class="link-arrow" href="/products/personal-loan"
                >Explore Personal Loan
                <svg width="15" height="15"><use href="#i-arrow-right" /></svg
              ></a>
            </article>

            <!-- Mahila Loan -->
            <article class="card product" data-reveal="zoom" data-tilt>
              <div class="card-icon">
                <svg><use href="#i-female" /></svg>
              </div>
              <h3>Mahila Loan</h3>
              <div class="product__sub">Empowering Women Entrepreneurs</div>
              <p>
                Designed to help women start or grow a business, pursue
                education or achieve financial independence — with subsidised,
                supportive terms.
              </p>
              <a class="link-arrow" href="/products/mahila-loan"
                >Start Your Mahila Loan
                <svg width="15" height="15"><use href="#i-arrow-right" /></svg
              ></a>
            </article>

            <!-- Consumer Loan -->
            <article class="card product" data-reveal="zoom" data-tilt>
              <div class="card-icon">
                <svg><use href="#i-tv" /></svg>
              </div>
              <h3>Consumer Loan</h3>
              <div class="product__sub">
                Buy What You Need, Pay at Your Pace
              </div>
              <p>
                From appliances to electronics and more — simple eligibility,
                competitive rates and convenient EMI options for your next
                purchase.
              </p>
              <a class="link-arrow" href="/products/consumer-loan"
                >Explore Consumer Loan
                <svg width="15" height="15"><use href="#i-arrow-right" /></svg
              ></a>
            </article>
          </div>
        </div>
      </section>

      <!-- ================= 06. INVESTMENTS ================= -->
      <section class="section section--gold" id="investment">
        <div class="container">
          <div class="section-head" data-reveal>
            <span class="eyebrow">Investments</span>
            <h2>
              Fixed-Return Options That
              <span class="gold-text">Show the Numbers</span>
            </h2>
            <p>
              Secured, predictable instruments for investors who want steady
              income without market volatility. Available through private offer.
            </p>
          </div>

          <div class="invtl" data-reveal>
            <div class="invtl__rail" role="tablist" aria-label="Investment options">
              <button class="invtl__step is-active" id="inv-tab-ncd" type="button"
                      role="tab" aria-selected="true" aria-controls="inv-panel-ncd">
                <span class="invtl__pill">Secured</span>
                <span class="invtl__dot" aria-hidden="true"></span>
              </button>
              <button class="invtl__step" id="inv-tab-sub" type="button"
                      role="tab" aria-selected="false" aria-controls="inv-panel-sub" tabindex="-1">
                <span class="invtl__pill">5 Year Term</span>
                <span class="invtl__dot" aria-hidden="true"></span>
              </button>
              <button class="invtl__step" id="inv-tab-dbl" type="button"
                      role="tab" aria-selected="false" aria-controls="inv-panel-dbl" tabindex="-1">
                <span class="invtl__pill">2x Target</span>
                <span class="invtl__dot" aria-hidden="true"></span>
              </button>
            </div>

            <!-- NCD -->
            <article class="invtl__panel" id="inv-panel-ncd" role="tabpanel" aria-labelledby="inv-tab-ncd" tabindex="0">
              <span class="invtl__tag">Secured</span>
              <div class="invtl__cols">
                <h3>Non-Convertible Debentures</h3>
                <div class="invtl__body">
                  <p>
                    Fixed interest income with monthly or quarterly payouts, secured
                    against company assets — a predictable way to grow savings
                    without market risk.
                  </p>
                  <ul class="invest__list">
                    <li><svg><use href="#i-check" /></svg> Secured against company assets</li>
                    <li><svg><use href="#i-check" /></svg> Choose from defined tenure options</li>
                    <li><svg><use href="#i-check" /></svg> Monthly / quarterly payout</li>
                    <li><svg><use href="#i-check" /></svg> Transferable with company approval</li>
                  </ul>
                  <a class="link-arrow invtl__cta" href="/investment/ncd"
                    >Explore NCD Options
                    <svg width="15" height="15"><use href="#i-arrow-right" /></svg
                  ></a>
                </div>
              </div>
            </article>

            <!-- Subordinated Debt -->
            <article class="invtl__panel" id="inv-panel-sub" role="tabpanel" aria-labelledby="inv-tab-sub" tabindex="0" hidden>
              <span class="invtl__tag">5-Year Term</span>
              <div class="invtl__cols">
                <h3>Subordinated Debt</h3>
                <div class="invtl__body">
                  <p>
                    Fixed monthly interest payout over a 5-year term — built for
                    long-term investors seeking reliable, predictable income from a
                    proven lender.
                  </p>
                  <ul class="invest__list">
                    <li><svg><use href="#i-check" /></svg> Fixed tenure — 60 or 72 months</li>
                    <li><svg><use href="#i-check" /></svg> Monthly, quarterly, yearly or on maturity</li>
                    <li><svg><use href="#i-check" /></svg> Non-marketable certificate</li>
                    <li><svg><use href="#i-check" /></svg> Cheque / account transfer only</li>
                  </ul>
                  <a class="link-arrow invtl__cta" href="/investment/subordinated-debt"
                    >Explore Subordinated Debt
                    <svg width="15" height="15"><use href="#i-arrow-right" /></svg
                  ></a>
                </div>
              </div>
            </article>

            <!-- Doubling -->
            <article class="invtl__panel" id="inv-panel-dbl" role="tabpanel" aria-labelledby="inv-tab-dbl" tabindex="0" hidden>
              <span class="invtl__tag">2x Target</span>
              <div class="invtl__cols">
                <h3>Doubling Sub-Debt Scheme</h3>
                <div class="invtl__body">
                  <p>
                    A 72-month plan that states your target maturity benefit — 2x
                    your investment — right on your certificate from day one.
                  </p>
                  <ul class="invest__list">
                    <li><svg><use href="#i-check" /></svg> 72-month tenure, 60-month lock-in</li>
                    <li><svg><use href="#i-check" /></svg> Invest ₹10,000 – ₹1 Crore</li>
                    <li><svg><use href="#i-check" /></svg> Target benefit stated in writing</li>
                    <li><svg><use href="#i-check" /></svg> TDS as per applicable IT rules</li>
                  </ul>
                  <a class="link-arrow invtl__cta" href="/investment/doubling-scheme"
                    >Explore the Doubling Scheme
                    <svg width="15" height="15"><use href="#i-arrow-right" /></svg
                  ></a>
                </div>
              </div>
            </article>
          </div>
        </div>
      </section>

      <!-- ================= 07. CALCULATOR ================= -->
      <section class="section section--alt" id="calculator">
        <div class="container">
          <div class="section-head" data-reveal>
            <span class="eyebrow">Instant Estimate</span>
            <h2>Gold Loan <span class="gold-text">Calculator</span></h2>
            <p>
              Switch between calculating by the gold you hold, or the cash you
              need.
            </p>
          </div>

          <div class="calc">
            <div class="calc__mascot" data-reveal="left">
              <div class="bubble" id="calcBubble">
                “How much gold do you have today?
                <em>Let me calculate for you.</em>”
              </div>
              <img
                src="{{ asset('assets/img/mascot.png') }}"
                alt="Invest Gold mascot ready to calculate"
                loading="lazy"
                decoding="async"
                width="1355"
                height="1160"
              />
            </div>

            <div class="calc__panel" data-reveal="right">
              <div
                class="switch"
                id="calcSwitch"
                data-mode="gold"
                role="tablist"
                aria-label="Calculator mode"
              >
                <span class="switch__thumb" aria-hidden="true"></span>
                <button
                  type="button"
                  role="tab"
                  aria-selected="true"
                  data-mode="gold"
                >
                  Calculate by Gold Weight
                </button>
                <button
                  type="button"
                  role="tab"
                  aria-selected="false"
                  data-mode="cash"
                >
                  Calculate by Cash Needed
                </button>
              </div>

              <!-- gold mode -->
              <div id="paneGold">
                <div class="field">
                  <label for="gWeight"
                    >Gold weight (grams) <b id="gWeightOut">40 g</b></label
                  >
                  <input
                    type="range"
                    id="gWeight"
                    min="1"
                    max="500"
                    step="1"
                    value="40"
                  />
                </div>
              </div>

              <!-- cash mode -->
              <div id="paneCash" hidden>
                <div class="field">
                  <label for="cAmount"
                    >Cash you need <b id="cAmountOut">₹2,00,000</b></label
                  >
                  <input
                    type="range"
                    id="cAmount"
                    min="10000"
                    max="5000000"
                    step="5000"
                    value="200000"
                  />
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
                  <label for="gRate">Rate per gram (22K) </label>
                  <input
                    class="input"
                    type="number"
                    id="gRate"
                    value="9200"
                    min="1000"
                    step="50"
                    inputmode="numeric"
                  />
                </div>
                <div class="field">
                  <label for="gTenure"
                    >Tenure (months) <b id="gTenureOut">12</b></label
                  >
                  <input
                    type="range"
                    id="gTenure"
                    min="3"
                    max="36"
                    step="1"
                    value="12"
                  />
                </div>
                <div class="field">
                  <label for="gInterest"
                    >Interest p.a. <b id="gInterestOut">12%</b></label
                  >
                  <input
                    type="range"
                    id="gInterest"
                    min="8"
                    max="24"
                    step="0.25"
                    value="12"
                  />
                </div>
              </div>

              <div class="calc__result">
                <small id="resultLabel">Eligible loan amount</small>
                <div class="calc__amount" id="resultAmount">₹2,76,000</div>
                <div class="calc__meta">
                  <div>
                    <b id="metaA">₹3,68,000</b
                    ><span id="metaALabel">Gold value</span>
                  </div>
                  <div><b id="metaB">75%</b><span>LTV applied</span></div>
                  <div><b id="metaC">₹24,540</b><span>Approx. EMI</span></div>
                </div>
                <div
                  style="
                    display: flex;
                    flex-wrap: wrap;
                    gap: 0.7rem;
                    margin-top: 1.3rem;
                  "
                >
                  <a
                    class="btn btn--gold btn--sm"
                    href="/contact?service=Gold%20Loan"
                    >Enquire Now
                    <svg width="15" height="15">
                      <use href="#i-arrow-right" /></svg
                  ></a>
                  <a class="btn btn--ghost btn--sm" href="/contact#branches"
                    >Visit Nearest Branch</a
                  >
                </div>
              </div>

              <p class="disclaimer">
                * Indicative estimate only. Actual eligibility depends on
                appraised purity, weight, the prevailing gold rate on the day of
                pledge and applicable scheme terms. Loan-to-value is capped as
                per RBI norms. Interest rate slabs may apply retrospectively
                from the pledge date — please confirm final figures at a branch.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- ================= 08. WHY CHOOSE US ================= -->
      <section class="section" id="why">
        <div class="container">
          <div class="section-head" data-reveal>
            <span class="eyebrow">Why Choose Us</span>
            <h2>
              What Makes Invest Gold
              <span class="gold-text">Kerala's Preferred NBFC</span>
            </h2>
            <p>
              From a single branch started in 1996 to a name families trust
              across Kerala today — here's what backs every loan and investment
              we offer.
            </p>
          </div>

          <div class="why">
            <article class="card" data-reveal="zoom">
              <span class="why__num">01</span>
              <div class="card-icon">
                <svg><use href="#i-shield" /></svg>
              </div>
              <h3>RBI Registered NBFC</h3>
              <p>
                A fully regulated, RBI-registered non-banking finance company —
                every product follows strict compliance and fair-practice norms,
                so you're protected by more than just our word.
              </p>
            </article>
            <article class="card" data-reveal="zoom">
              <span class="why__num">02</span>
              <div class="card-icon">
                <svg><use href="#i-building" /></svg>
              </div>
              <h3>Serving Kerala Since 1996</h3>
              <p>
                What began as a single office in Thrissur has grown into a
                trusted network of branches reaching families statewide — the
                same values, now closer to you.
              </p>
            </article>
            <article class="card" data-reveal="zoom">
              <span class="why__num">03</span>
              <div class="card-icon">
                <svg><use href="#i-users" /></svg>
              </div>
              <h3>One Team, Every Need</h3>
              <p>
                From gold and personal loans to Mahila loans, NCDs and
                Subordinated Debt — a single trusted partner for both your
                borrowing and your savings goals.
              </p>
            </article>
            <article class="card" data-reveal="zoom">
              <span class="why__num">04</span>
              <div class="card-icon">
                <svg><use href="#i-doc" /></svg>
              </div>
              <h3>Transparent Terms, Always</h3>
              <p>
                No hidden charges, no fine-print surprises. Every rate, term and
                repayment schedule is laid out clearly — track it all with our
                online live passbook on the mobile app.
              </p>
            </article>
          </div>

          <div
            class="hero__badges"
            style="margin-top: clamp(1.8rem, 4vw, 2.8rem)"
          >
            <div class="badge" data-reveal="zoom">
              <svg><use href="#i-shield" /></svg>
              <b>RBI</b><span>Registered NBFC</span>
            </div>
            <div class="badge" data-reveal="zoom">
              <svg><use href="#i-users" /></svg>
              <b><span data-count="10000">0</span>+</b
              ><span>Happy Customers</span>
            </div>
            <div class="badge" data-reveal="zoom">
              <svg><use href="#i-building" /></svg>
              <b>Kerala</b><span>Branches Statewide</span>
            </div>
          </div>
        </div>
      </section>

      <!-- ================= 09. TESTIMONIALS ================= -->
      <section class="section section--deep" id="testimonials">
        <div class="container">
          <div class="section-head" data-reveal>
            <span class="eyebrow">Customer Stories</span>
            <h2>Trusted by <span class="gold-text">10,000+ Families</span></h2>
          </div>

          <div class="tcar" id="tcar" data-reveal>
            <button
              class="tcar__nav tcar__nav--prev"
              type="button"
              aria-label="Previous story"
            >
              <svg width="20" height="20"><use href="#i-chev-left" /></svg>
            </button>
            <div class="tcar__viewport">
              <div class="tcar__track" id="tcarTrack">
                <div class="tslide">
                  <div class="tslide__card">
                    <span class="tslide__avatar">R</span>
                    <div class="stars">
                      <svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg>
                    </div>
                    <q
                      >Quick, transparent and genuinely hassle-free. The
                      valuation was explained clearly, the paperwork was
                      minimal, and the whole process felt effortless from start
                      to finish.</q
                    >
                    <div class="tslide__name">Radhika S.</div>
                    <div class="tslide__loc">Thrissur</div>
                  </div>
                </div>

                <div class="tslide">
                  <div class="tslide__card">
                    <span class="tslide__avatar">M</span>
                    <div class="stars">
                      <svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg>
                    </div>
                    <q
                      >I needed funds urgently, and Invest Gold delivered —
                      same-day approval, no unnecessary delays. That kind of
                      reliability is hard to find elsewhere.</q
                    >
                    <div class="tslide__name">Manoj K.</div>
                    <div class="tslide__loc">Irinjalakuda</div>
                  </div>
                </div>

                <div class="tslide">
                  <div class="tslide__card">
                    <span class="tslide__avatar">S</span>
                    <div class="stars">
                      <svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg>
                    </div>
                    <q
                      >The Mahila Loan helped me expand my tailoring unit into a
                      proper shop. The team guided me through every document and
                      the repayment fits my cash flow.</q
                    >
                    <div class="tslide__name">Sreelatha P.</div>
                    <div class="tslide__loc">Kunnamkulam</div>
                  </div>
                </div>

                <div class="tslide">
                  <div class="tslide__card">
                    <span class="tslide__avatar">A</span>
                    <div class="stars">
                      <svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg>
                    </div>
                    <q
                      >I have held a Subordinated Debt certificate for three
                      years. The monthly payout has arrived on time, every time,
                      and the statements are always clear.</q
                    >
                    <div class="tslide__name">Anil Kumar V.</div>
                    <div class="tslide__loc">Guruvayur</div>
                  </div>
                </div>

                <div class="tslide">
                  <div class="tslide__card">
                    <span class="tslide__avatar">F</span>
                    <div class="stars">
                      <svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg
                      ><svg><use href="#i-star" /></svg>
                    </div>
                    <q
                      >The live passbook on the app is the best part — I can
                      check my interest due and pay from home instead of
                      travelling to the branch every month.</q
                    >
                    <div class="tslide__name">Fathima N.</div>
                    <div class="tslide__loc">Chavakkad</div>
                  </div>
                </div>
              </div>
            </div>
            <button
              class="tcar__nav tcar__nav--next"
              type="button"
              aria-label="Next story"
            >
              <svg width="20" height="20"><use href="#i-chev-right" /></svg>
            </button>
            <div class="tcar__dots" id="tcarDots"></div>
          </div>
        </div>
      </section>

      <!-- ================= 10. MOBILE APP ================= -->
      <section class="section" id="app">
        <div class="container app">
          <div data-reveal="left">
            <span class="eyebrow">Invest Gold Mobile App</span>
            <h2 style="margin: 1.1rem 0 1rem">
              Manage Your Loans <span class="gold-text">Anytime, Anywhere</span>
            </h2>
            <p>
              The Invest Gold Mobile App brings all your financial services
              together in one secure, easy-to-use platform. Apply for loans,
              manage your accounts, pay interest, track transactions and access
              our services from anywhere.
            </p>
            <ul class="app__list">
              <li>
                <svg><use href="#i-check" /></svg> Apply for gold, personal,
                Mahila &amp; consumer loans
              </li>
              <li>
                <svg><use href="#i-check" /></svg> Online live passbook with
                real-time balances
              </li>
              <li>
                <svg><use href="#i-check" /></svg> Pay interest and EMIs
                securely in a few taps
              </li>
              <li>
                <svg><use href="#i-check" /></svg> Branch locator, gold
                calculator and instant support
              </li>
            </ul>
            <h3 style="font-size: 1.05rem; margin-bottom: 0.9rem">
              Download Now
            </h3>
            <div class="store">
              <a href="#" aria-label="Get it on Google Play">
                <svg><use href="#i-play" /></svg>
                <span><small>Get it on</small><b>Google Play</b></span>
              </a>
              <a href="#" aria-label="Download on the App Store">
                <svg><use href="#i-apple" /></svg>
                <span><small>Download on the</small><b>App Store</b></span>
              </a>
            </div>
          </div>

          <!-- App screen carousel (pure CSS/SVG mock screens) -->
          <div class="phones" data-reveal="right">
            <div class="phones__stage" id="phones">
              <!-- 1 · Dashboard -->
              <div class="phone">
                <svg
                  viewBox="0 0 216 440"
                  role="img"
                  aria-label="App dashboard screen"
                >
                  <rect width="216" height="440" fill="#0B1B3F" />
                  <rect width="216" height="96" fill="#12275A" />
                  <circle cx="30" cy="46" r="12" fill="#D4AF37" />
                  <rect
                    x="50"
                    y="38"
                    width="70"
                    height="7"
                    rx="3.5"
                    fill="#E7C766"
                  />
                  <rect
                    x="50"
                    y="52"
                    width="46"
                    height="6"
                    rx="3"
                    fill="#5B6C9E"
                  />
                  <rect
                    x="16"
                    y="72"
                    width="184"
                    height="52"
                    rx="12"
                    fill="#0A0F2C"
                    stroke="#D4AF37"
                    stroke-opacity=".5"
                  />
                  <rect
                    x="28"
                    y="86"
                    width="60"
                    height="6"
                    rx="3"
                    fill="#5B6C9E"
                  />
                  <rect
                    x="28"
                    y="100"
                    width="92"
                    height="11"
                    rx="4"
                    fill="#E7C766"
                  />
                  <g fill="#12275A">
                    <rect x="16" y="140" width="86" height="76" rx="14" />
                    <rect x="114" y="140" width="86" height="76" rx="14" />
                    <rect x="16" y="228" width="86" height="76" rx="14" />
                    <rect x="114" y="228" width="86" height="76" rx="14" />
                  </g>
                  <g fill="#D4AF37">
                    <circle cx="59" cy="168" r="11" />
                    <circle cx="157" cy="168" r="11" />
                    <circle cx="59" cy="256" r="11" />
                    <circle cx="157" cy="256" r="11" />
                  </g>
                  <g fill="#8494C4">
                    <rect x="35" y="190" width="48" height="6" rx="3" />
                    <rect x="133" y="190" width="48" height="6" rx="3" />
                    <rect x="35" y="278" width="48" height="6" rx="3" />
                    <rect x="133" y="278" width="48" height="6" rx="3" />
                  </g>
                  <rect
                    x="16"
                    y="320"
                    width="184"
                    height="42"
                    rx="12"
                    fill="#D4AF37"
                  />
                  <rect
                    x="70"
                    y="337"
                    width="76"
                    height="8"
                    rx="4"
                    fill="#0B1B3F"
                  />
                  <rect x="0" y="392" width="216" height="48" fill="#12275A" />
                  <g fill="#5B6C9E">
                    <circle cx="43" cy="416" r="7" />
                    <circle cx="108" cy="416" r="7" />
                    <circle cx="173" cy="416" r="7" />
                  </g>
                </svg>
              </div>
              <!-- 2 · My loans -->
              <div class="phone">
                <svg
                  viewBox="0 0 216 440"
                  role="img"
                  aria-label="My loans screen"
                >
                  <rect width="216" height="440" fill="#0A0F2C" />
                  <rect width="216" height="70" fill="#D4AF37" />
                  <rect
                    x="20"
                    y="32"
                    width="72"
                    height="9"
                    rx="4.5"
                    fill="#0B1B3F"
                  />
                  <g fill="#12275A">
                    <rect x="16" y="88" width="184" height="88" rx="14" />
                    <rect x="16" y="188" width="184" height="88" rx="14" />
                    <rect x="16" y="288" width="184" height="88" rx="14" />
                  </g>
                  <g fill="#E7C766">
                    <rect x="30" y="106" width="70" height="8" rx="4" />
                    <rect x="30" y="206" width="70" height="8" rx="4" />
                    <rect x="30" y="306" width="70" height="8" rx="4" />
                  </g>
                  <g fill="#5B6C9E">
                    <rect x="30" y="124" width="110" height="6" rx="3" />
                    <rect x="30" y="140" width="86" height="6" rx="3" />
                    <rect x="30" y="224" width="110" height="6" rx="3" />
                    <rect x="30" y="240" width="86" height="6" rx="3" />
                    <rect x="30" y="324" width="110" height="6" rx="3" />
                    <rect x="30" y="340" width="86" height="6" rx="3" />
                  </g>
                  <g fill="#D4AF37">
                    <rect x="140" y="150" width="46" height="16" rx="8" />
                    <rect x="140" y="250" width="46" height="16" rx="8" />
                    <rect x="140" y="350" width="46" height="16" rx="8" />
                  </g>
                </svg>
              </div>
              <!-- 3 · Biometrics -->
              <div class="phone">
                <svg
                  viewBox="0 0 216 440"
                  role="img"
                  aria-label="Secure login screen"
                >
                  <rect width="216" height="440" fill="#0B1B3F" />
                  <circle
                    cx="108"
                    cy="150"
                    r="58"
                    fill="#12275A"
                    stroke="#D4AF37"
                    stroke-width="2"
                  />
                  <path
                    d="M108 116c-16 0-29 13-29 29v22c0 16 13 29 29 29s29-13 29-29v-22c0-16-13-29-29-29z"
                    fill="none"
                    stroke="#E7C766"
                    stroke-width="3"
                  />
                  <path
                    d="M96 150c0-7 5-12 12-12s12 5 12 12v18"
                    fill="none"
                    stroke="#E7C766"
                    stroke-width="3"
                    stroke-linecap="round"
                  />
                  <rect
                    x="46"
                    y="238"
                    width="124"
                    height="10"
                    rx="5"
                    fill="#E7C766"
                  />
                  <g fill="#5B6C9E">
                    <rect x="34" y="266" width="148" height="6" rx="3" />
                    <rect x="52" y="282" width="112" height="6" rx="3" />
                  </g>
                  <rect
                    x="30"
                    y="326"
                    width="156"
                    height="44"
                    rx="12"
                    fill="#D4AF37"
                  />
                  <rect
                    x="78"
                    y="344"
                    width="60"
                    height="8"
                    rx="4"
                    fill="#0B1B3F"
                  />
                  <rect
                    x="30"
                    y="382"
                    width="156"
                    height="14"
                    rx="7"
                    fill="#12275A"
                  />
                </svg>
              </div>
              <!-- 4 · Pay interest -->
              <div class="phone">
                <svg
                  viewBox="0 0 216 440"
                  role="img"
                  aria-label="Pay interest screen"
                >
                  <rect width="216" height="440" fill="#0A0F2C" />
                  <rect width="216" height="180" rx="0" fill="#12275A" />
                  <circle
                    cx="108"
                    cy="86"
                    r="34"
                    fill="none"
                    stroke="#D4AF37"
                    stroke-width="3"
                  />
                  <path
                    d="M96 86l9 9 17-19"
                    fill="none"
                    stroke="#E7C766"
                    stroke-width="4"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <rect
                    x="58"
                    y="136"
                    width="100"
                    height="9"
                    rx="4.5"
                    fill="#E7C766"
                  />
                  <rect
                    x="16"
                    y="204"
                    width="184"
                    height="60"
                    rx="14"
                    fill="#12275A"
                  />
                  <rect
                    x="30"
                    y="220"
                    width="60"
                    height="6"
                    rx="3"
                    fill="#5B6C9E"
                  />
                  <rect
                    x="30"
                    y="234"
                    width="96"
                    height="12"
                    rx="5"
                    fill="#D4AF37"
                  />
                  <g fill="#12275A">
                    <rect x="16" y="278" width="88" height="40" rx="10" />
                    <rect x="112" y="278" width="88" height="40" rx="10" />
                  </g>
                  <g fill="#5B6C9E">
                    <rect x="32" y="294" width="56" height="7" rx="3.5" />
                    <rect x="128" y="294" width="56" height="7" rx="3.5" />
                  </g>
                  <rect
                    x="16"
                    y="340"
                    width="184"
                    height="44"
                    rx="12"
                    fill="#D4AF37"
                  />
                  <rect
                    x="76"
                    y="358"
                    width="64"
                    height="8"
                    rx="4"
                    fill="#0B1B3F"
                  />
                </svg>
              </div>
              <!-- 5 · Gold calculator -->
              <div class="phone">
                <svg
                  viewBox="0 0 216 440"
                  role="img"
                  aria-label="Gold calculator screen"
                >
                  <rect width="216" height="440" fill="#0B1B3F" />
                  <rect width="216" height="62" fill="#12275A" />
                  <rect
                    x="20"
                    y="28"
                    width="88"
                    height="8"
                    rx="4"
                    fill="#E7C766"
                  />
                  <ellipse
                    cx="108"
                    cy="124"
                    rx="44"
                    ry="16"
                    fill="#D4AF37"
                    opacity=".9"
                  />
                  <path
                    d="M64 124v22c0 9 20 16 44 16s44-7 44-16v-22"
                    fill="#C9A227"
                  />
                  <rect
                    x="20"
                    y="188"
                    width="176"
                    height="8"
                    rx="4"
                    fill="#5B6C9E"
                  />
                  <rect
                    x="20"
                    y="188"
                    width="112"
                    height="8"
                    rx="4"
                    fill="#D4AF37"
                  />
                  <circle cx="132" cy="192" r="11" fill="#F2DFA0" />
                  <rect
                    x="20"
                    y="224"
                    width="176"
                    height="8"
                    rx="4"
                    fill="#5B6C9E"
                  />
                  <rect
                    x="20"
                    y="224"
                    width="66"
                    height="8"
                    rx="4"
                    fill="#D4AF37"
                  />
                  <circle cx="86" cy="228" r="11" fill="#F2DFA0" />
                  <rect
                    x="16"
                    y="264"
                    width="184"
                    height="74"
                    rx="14"
                    fill="#12275A"
                    stroke="#D4AF37"
                    stroke-opacity=".5"
                  />
                  <rect
                    x="32"
                    y="282"
                    width="70"
                    height="6"
                    rx="3"
                    fill="#5B6C9E"
                  />
                  <rect
                    x="32"
                    y="298"
                    width="118"
                    height="16"
                    rx="6"
                    fill="#E7C766"
                  />
                  <rect
                    x="16"
                    y="356"
                    width="184"
                    height="42"
                    rx="12"
                    fill="#D4AF37"
                  />
                  <rect
                    x="72"
                    y="373"
                    width="72"
                    height="8"
                    rx="4"
                    fill="#0B1B3F"
                  />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ================= 11. NEWS & EVENTS ================= -->
      <section class="section section--alt" id="news">
        <div class="container">
          <div class="section-head" data-reveal>
            <span class="eyebrow">News &amp; Events</span>
            <h2>
              What's Happening at <span class="gold-text">Invest Gold</span>
            </h2>
            <p>
              Branch launches, community initiatives and company milestones from
              across Kerala.
            </p>
          </div>

          <div class="grid grid--3">
            <article class="card news" data-reveal="zoom">
              <div class="news__media">
                <span class="news__date">12 Mar 2026</span
                ><svg><use href="#i-building" /></svg>
              </div>
              <h3>New Branch Opens in Kunnamkulam</h3>
              <p>
                Our newest branch brings gold loans, Mahila loans and investment
                services closer to families in the Kunnamkulam region.
              </p>
              <a class="link-arrow" href="/news"
                >Learn More
                <svg width="15" height="15"><use href="#i-arrow-right" /></svg
              ></a>
            </article>

            <article class="card news" data-reveal="zoom">
              <div class="news__media">
                <span class="news__date">28 Jan 2026</span
                ><svg><use href="#i-female" /></svg>
              </div>
              <h3>Mahila Entrepreneurship Meet, Thrissur</h3>
              <p>
                Over 200 women entrepreneurs joined our annual meet for sessions
                on business planning, credit readiness and growth funding.
              </p>
              <a class="link-arrow" href="/news"
                >Learn More
                <svg width="15" height="15"><use href="#i-arrow-right" /></svg
              ></a>
            </article>

            <article class="card news" data-reveal="zoom">
              <div class="news__media">
                <span class="news__date">05 Dec 2025</span
                ><svg><use href="#i-award" /></svg>
              </div>
              <h3>Three Decades of Trusted Lending</h3>
              <p>
                From a single Urakam office in 1996 to a statewide network — a
                look back at the milestones that shaped Invest Gold.
              </p>
              <a class="link-arrow" href="/news"
                >Learn More
                <svg width="15" height="15"><use href="#i-arrow-right" /></svg
              ></a>
            </article>
          </div>
        </div>
      </section>

      <!-- ================= 14. FAQ ================= -->
      <section class="section" id="faq">
        <div class="container">
          <div class="section-head" data-reveal>
            <span class="eyebrow">FAQ</span>
            <h2>Questions, <span class="gold-text">Answered</span></h2>
          </div>

          <div class="faq" id="faqList">
            <div class="acc" data-reveal>
              <button class="acc__btn" type="button" aria-expanded="false">
                Is Invest Gold General Finance a legitimate, RBI-registered
                company?
                <span class="acc__icon"
                  ><svg width="14" height="14"><use href="#i-plus" /></svg
                ></span>
              </button>
              <div class="acc__panel">
                <div>
                  <p>
                    Yes. We are a fully RBI-registered NBFC operating in Kerala
                    since 1996, with every loan and investment product following
                    strict compliance and fair-practice norms.
                  </p>
                </div>
              </div>
            </div>

            <div class="acc" data-reveal>
              <button class="acc__btn" type="button" aria-expanded="false">
                How long has Invest Gold been operating in Kerala?
                <span class="acc__icon"
                  ><svg width="14" height="14"><use href="#i-plus" /></svg
                ></span>
              </button>
              <div class="acc__panel">
                <div>
                  <p>
                    Since 1996 — starting as a single office in Thrissur and
                    growing into a trusted network of branches serving families
                    statewide.
                  </p>
                </div>
              </div>
            </div>

            <div class="acc" data-reveal>
              <button class="acc__btn" type="button" aria-expanded="false">
                What types of loans does Invest Gold offer?
                <span class="acc__icon"
                  ><svg width="14" height="14"><use href="#i-plus" /></svg
                ></span>
              </button>
              <div class="acc__panel">
                <div>
                  <p>
                    Gold Loans, Personal Loans, Mahila Loans and Consumer Loans
                    — each with flexible eligibility, minimal paperwork and
                    competitive rates.
                  </p>
                </div>
              </div>
            </div>

            <div class="acc" data-reveal>
              <button class="acc__btn" type="button" aria-expanded="false">
                Does Invest Gold offer investment options, not just loans?
                <span class="acc__icon"
                  ><svg width="14" height="14"><use href="#i-plus" /></svg
                ></span>
              </button>
              <div class="acc__panel">
                <div>
                  <p>
                    Yes — we offer Non-Convertible Debentures (NCDs),
                    Subordinated Debts and the Doubling Sub-Debt Scheme:
                    fixed-return investment instruments for customers looking to
                    grow their savings securely, through private offers. Contact
                    us to learn more.
                  </p>
                </div>
              </div>
            </div>

            <div class="acc" data-reveal>
              <button class="acc__btn" type="button" aria-expanded="false">
                Does Invest Gold have a mobile app?
                <span class="acc__icon"
                  ><svg width="14" height="14"><use href="#i-plus" /></svg
                ></span>
              </button>
              <div class="acc__panel">
                <div>
                  <p>
                    Yes — the Invest Gold app lets you apply for loans, manage
                    your account, pay interest and track transactions anytime.
                    Available on the Play Store and App Store.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ================= 15. ENQUIRY / CONTACT ================= -->
      <section class="section section--alt" id="contact">
        <div class="container">
          <div class="section-head" data-reveal>
            <span class="eyebrow">Get in Touch</span>
            <h2>
              Reach Out — <span class="gold-text">We're Ready to Help</span>
            </h2>
            <p>
              Have a question or need assistance? Fill out the form and our team
              will get back to you shortly.
            </p>
          </div>

          <div class="enquiry">
            <div class="contact-card" data-reveal="left">
              <div class="contact-row">
                <svg><use href="#i-building" /></svg>
                <div>
                  <b>Corporate &amp; Head Office</b
                  ><span
                    >Invest Gold &amp; General Finance (P) Limited<br />Invest
                    Complex, Urakam PO,<br />Thrissur, Kerala, India –
                    680562</span
                  >
                </div>
              </div>
              <div class="contact-row">
                <svg><use href="#i-phone" /></svg>
                <div>
                  <b>Phone</b
                  ><span
                    ><a href="tel:+917034000444">+91 7034 000 444</a>
                    &nbsp;·&nbsp;
                    <a href="tel:+919074523723">+91 90745 23723</a></span
                  >
                </div>
              </div>
              <div class="contact-row">
                <svg><use href="#i-mail" /></svg>
                <div>
                  <b>Email</b
                  ><span
                    ><a href="mailto:info@investgoldfinance.com"
                      >info@investgoldfinance.com</a
                    ></span
                  >
                </div>
              </div>
              <div class="contact-row">
                <svg><use href="#i-whatsapp" /></svg>
                <div>
                  <b>WhatsApp</b
                  ><span
                    ><a
                      href="https://wa.me/919074523723"
                      target="_blank"
                      rel="noopener"
                      >Chat with our team →</a
                    ></span
                  >
                </div>
              </div>
              <div class="contact-row">
                <svg><use href="#i-clock" /></svg>
                <div>
                  <b>Working Hours</b
                  ><span>Monday – Saturday · 9:30 AM to 5:30 PM</span>
                </div>
              </div>
            </div>

            <form
              class="enquiry__form"
              id="enquiryForm"
              novalidate
              data-reveal="right"
            >
              <div class="form-grid">
                <div class="field">
                  <label for="fName">Name</label>
                  <input
                    class="input"
                    type="text"
                    id="fName"
                    name="name"
                    placeholder="Your full name"
                    autocomplete="name"
                    required
                  />
                  <span class="err">Please enter your name.</span>
                </div>
                <div class="field">
                  <label for="fPhone">Phone number</label>
                  <input
                    class="input"
                    type="tel"
                    id="fPhone"
                    name="phone"
                    placeholder="10-digit mobile number"
                    autocomplete="tel"
                    inputmode="numeric"
                    required
                  />
                  <span class="err">Please enter a valid 10-digit number.</span>
                </div>
                <div class="field">
                  <label for="fEmail">Email</label>
                  <input
                    class="input"
                    type="email"
                    id="fEmail"
                    name="email"
                    placeholder="you@example.com"
                    autocomplete="email"
                    required
                  />
                  <span class="err">Please enter a valid email address.</span>
                </div>
                <div class="field">
                  <label for="fService">Service</label>
                  <select class="select" id="fService" name="service" required>
                    <option value="">Select a service</option>
                    <optgroup label="Loans">
                      <option>Gold Loan</option>
                      <option>Personal Loan</option>
                      <option>Mahila Loan</option>
                      <option>Consumer Loan</option>
                    </optgroup>
                    <optgroup label="Investments">
                      <option>NCD Investment</option>
                      <option>SD Investment</option>
                      <option>Doubling Investment</option>
                    </optgroup>
                    <optgroup label="Other">
                      <option>Mobile App Support</option>
                      <option>Careers</option>
                      <option>General Enquiry</option>
                    </optgroup>
                  </select>
                  <span class="err">Please choose a service.</span>
                </div>
                <div class="field field--full">
                  <label for="fMessage">Message</label>
                  <textarea
                    class="textarea"
                    id="fMessage"
                    name="message"
                    placeholder="Tell us how we can help…"
                  ></textarea>
                </div>
              </div>
              <button
                class="btn btn--gold btn--block"
                type="submit"
                style="margin-top: 1.3rem"
              >
                Submit Enquiry
                <svg width="16" height="16"><use href="#i-arrow-right" /></svg>
              </button>
              <p class="form-note disclaimer">
                By submitting, you agree to be contacted by our team regarding
                your enquiry. We never share your details with third parties.
              </p>
              <div class="form-ok" id="formOk" role="status">
                <b>Thank you!</b> Your enquiry has been recorded. Our team will
                get in touch with you shortly.
              </div>
            </form>
          </div>
        </div>
      </section>
@endsection
