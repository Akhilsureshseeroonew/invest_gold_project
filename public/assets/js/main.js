/* =============================================================
   INVEST GOLD — interactions (vanilla JS, no dependencies)
   01 theme     05 counters      09 phone carousel  13 branch search
   02 nav       06 card glow     10 FAQ             14 back to top
   03 progress  07 calculator    11 enquiry form
   04 reveal    08 testimonials  12 floating FAB    16 service prefill  19 modals
   ——           ——               ——                17 gallery         20 apply form
   ——           ——               ——                18 rate cards
   ============================================================= */
(function () {
  "use strict";

  var $ = function (s, c) {
    return (c || document).querySelector(s);
  };
  var $$ = function (s, c) {
    return Array.prototype.slice.call((c || document).querySelectorAll(s));
  };
  var reduceMotion = window.matchMedia(
    "(prefers-reduced-motion: reduce)",
  ).matches;
  var inr = new Intl.NumberFormat("en-IN", { maximumFractionDigits: 0 });
  var money = function (n) {
    return "₹" + inr.format(Math.max(0, Math.round(n)));
  };

  /* ---------- 01. THEME ---------- */
  (function theme() {
    var btn = $("#themeToggle");
    if (!btn) return;
    btn.addEventListener("click", function () {
      var next =
        document.documentElement.getAttribute("data-theme") === "light"
          ? "dark"
          : "light";
      document.documentElement.setAttribute("data-theme", next);
      var meta = document.querySelector('meta[name="theme-color"]');
      if (meta)
        meta.setAttribute("content", next === "light" ? "#FCFAF5" : "#0A0F2C");
      try {
        localStorage.setItem("ig-theme", next);
      } catch (e) {}
    });
  })();

  /* ---------- 02. NAVIGATION ---------- */
  (function nav() {
    var nav = $("#nav"),
      burger = $("#burger"),
      links = $$("#navLinks a");

    burger.addEventListener("click", function () {
      var open = nav.classList.toggle("is-open");
      burger.setAttribute("aria-expanded", String(open));
    });

    links.forEach(function (a) {
      a.addEventListener("click", function () {
        nav.classList.remove("is-open");
        burger.setAttribute("aria-expanded", "false");
      });
    });

    document.addEventListener("click", function (e) {
      if (nav.classList.contains("is-open") && !nav.contains(e.target)) {
        nav.classList.remove("is-open");
        burger.setAttribute("aria-expanded", "false");
      }
    });

    // sticky shadow + scroll-spy (spy only applies to same-page anchors)
    var spyLinks = links.filter(function (a) {
      return a.getAttribute("href").charAt(0) === "#";
    });
    var sections = spyLinks
      .map(function (a) {
        return document.querySelector(a.getAttribute("href"));
      })
      .filter(Boolean);
    var onScroll = function () {
      nav.classList.toggle("is-stuck", window.scrollY > 20);
      if (!sections.length) return;
      var pos = window.scrollY + window.innerHeight * 0.32,
        current = sections[0];
      sections.forEach(function (s) {
        if (s.offsetTop <= pos) current = s;
      });
      spyLinks.forEach(function (a) {
        a.classList.toggle(
          "is-active",
          current && a.getAttribute("href") === "#" + current.id,
        );
      });
    };
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();
  })();

  /* ---------- 03. SCROLL PROGRESS ---------- */
  (function progress() {
    var bar = $("#progress");
    var update = function () {
      var h = document.documentElement.scrollHeight - window.innerHeight;
      bar.style.width = (h > 0 ? (window.scrollY / h) * 100 : 0) + "%";
    };
    window.addEventListener("scroll", update, { passive: true });
    window.addEventListener("resize", update);
    update();
  })();

  /* ---------- 04. SCROLL REVEAL ---------- */
  (function reveal() {
    var items = $$("[data-reveal]");
    if (!("IntersectionObserver" in window) || reduceMotion) {
      items.forEach(function (el) {
        el.classList.add("is-visible");
      });
      return;
    }
    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (en, i) {
          if (!en.isIntersecting) return;
          var el = en.target;
          // stagger siblings for a smooth cascade
          var delay = Math.min(i * 90, 360);
          setTimeout(function () {
            el.classList.add("is-visible");
          }, delay);
          io.unobserve(el);
        });
      },
      { threshold: 0.12, rootMargin: "0px 0px -8% 0px" },
    );
    items.forEach(function (el) {
      io.observe(el);
    });
  })();

  /* ---------- 05. COUNTERS ---------- */
  (function counters() {
    var nodes = $$("[data-count]");
    if (!nodes.length) return;
    var run = function (el) {
      var target = parseInt(el.getAttribute("data-count"), 10) || 0;
      if (reduceMotion) {
        el.textContent = inr.format(target);
        return;
      }
      var start = performance.now(),
        dur = 1600;
      var tick = function (now) {
        var p = Math.min((now - start) / dur, 1);
        var eased = 1 - Math.pow(1 - p, 3);
        el.textContent = inr.format(Math.round(target * eased));
        if (p < 1) requestAnimationFrame(tick);
      };
      requestAnimationFrame(tick);
    };
    if (!("IntersectionObserver" in window)) {
      nodes.forEach(run);
      return;
    }
    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (en) {
          if (en.isIntersecting) {
            run(en.target);
            io.unobserve(en.target);
          }
        });
      },
      { threshold: 0.6 },
    );
    nodes.forEach(function (el) {
      io.observe(el);
    });
  })();

  /* ---------- 06. CARD POINTER GLOW ---------- */
  (function cardGlow() {
    if (reduceMotion || window.matchMedia("(hover: none)").matches) return;
    $$(".card").forEach(function (card) {
      card.addEventListener("pointermove", function (e) {
        var r = card.getBoundingClientRect();
        card.style.setProperty(
          "--mx",
          ((e.clientX - r.left) / r.width) * 100 + "%",
        );
        card.style.setProperty(
          "--my",
          ((e.clientY - r.top) / r.height) * 100 + "%",
        );
      });
    });
  })();

  /* ---------- 07. CALCULATOR ---------- */
  (function calculator() {
    var sw = $("#calcSwitch");
    if (!sw) return;

    var el = {
      paneGold: $("#paneGold"),
      paneCash: $("#paneCash"),
      weight: $("#gWeight"),
      weightOut: $("#gWeightOut"),
      amount: $("#cAmount"),
      amountOut: $("#cAmountOut"),
      purity: $("#gPurity"),
      rate: $("#gRate"),
      tenure: $("#gTenure"),
      tenureOut: $("#gTenureOut"),
      interest: $("#gInterest"),
      interestOut: $("#gInterestOut"),
      label: $("#resultLabel"),
      amountOutBig: $("#resultAmount"),
      metaA: $("#metaA"),
      metaALabel: $("#metaALabel"),
      metaB: $("#metaB"),
      metaC: $("#metaC"),
      bubble: $("#calcBubble"),
    };
    var LTV = 0.75; // capped per RBI norms

    // paint the filled portion of every range input
    var paintRange = function (input) {
      var min = parseFloat(input.min),
        max = parseFloat(input.max);
      var pct = ((parseFloat(input.value) - min) / (max - min)) * 100;
      input.style.setProperty("--fill", pct + "%");
    };

    var emi = function (principal, annualRate, months) {
      var r = annualRate / 12 / 100;
      if (!r) return principal / months;
      var f = Math.pow(1 + r, months);
      return (principal * r * f) / (f - 1);
    };

    function compute() {
      var mode = sw.getAttribute("data-mode");
      var purity = parseFloat(el.purity.value) || 1;
      var rate = parseFloat(el.rate.value) || 0;
      var months = parseInt(el.tenure.value, 10);
      var interest = parseFloat(el.interest.value);

      el.weightOut.textContent = el.weight.value + " g";
      el.amountOut.textContent = money(el.amount.value);
      el.tenureOut.textContent = months + " mo";
      el.interestOut.textContent =
        interest.toFixed(2).replace(/\.00$/, "") + "%";
      [el.weight, el.amount, el.tenure, el.interest].forEach(paintRange);

      if (mode === "gold") {
        var grams = parseFloat(el.weight.value);
        var goldValue = grams * rate * purity;
        var eligible = goldValue * LTV;
        el.label.textContent = "Eligible loan amount";
        el.amountOutBig.textContent = money(eligible);
        el.metaALabel.textContent = "Gold value";
        el.metaA.textContent = money(goldValue);
        el.metaC.textContent = money(emi(eligible, interest, months));
      } else {
        var cash = parseFloat(el.amount.value);
        var neededValue = cash / LTV;
        var gramsNeeded = rate * purity > 0 ? neededValue / (rate * purity) : 0;
        el.label.textContent = "Gold you need to pledge";
        el.amountOutBig.textContent = gramsNeeded.toFixed(1) + " g";
        el.metaALabel.textContent = "Gold value needed";
        el.metaA.textContent = money(neededValue);
        el.metaC.textContent = money(emi(cash, interest, months));
      }
      el.metaB.textContent = LTV * 100 + "%";
    }

    sw.addEventListener("click", function (e) {
      var btn = e.target.closest("button[data-mode]");
      if (!btn) return;
      var mode = btn.getAttribute("data-mode");
      sw.setAttribute("data-mode", mode);
      $$("button[data-mode]", sw).forEach(function (b) {
        b.setAttribute("aria-selected", String(b === btn));
      });
      el.paneGold.hidden = mode !== "gold";
      el.paneCash.hidden = mode !== "cash";
      el.bubble.innerHTML =
        mode === "gold"
          ? "“How much gold do you have today? <em>Let me calculate for you.</em>”"
          : "“How much cash do you need today? <em>Let me calculate for you.</em>”";
      compute();
    });

    ["input", "change"].forEach(function (evt) {
      [
        el.weight,
        el.amount,
        el.purity,
        el.rate,
        el.tenure,
        el.interest,
      ].forEach(function (i) {
        i.addEventListener(evt, compute);
      });
    });
    compute();
  })();

  /* ---------- 08. TESTIMONIAL CAROUSEL ---------- */
  (function testimonials() {
    var root = $("#tcar"),
      track = $("#tcarTrack"),
      dotsWrap = $("#tcarDots");
    if (!root || !track) return;

    var originals = $$(".tslide", track);
    var total = originals.length;
    var index = 0,
      perView = 3,
      offset = 1,
      timer = null,
      animating = false;

    function perViewFor(w) {
      return w > 1024 ? 3 : w > 760 ? 2 : 1;
    }

    function build() {
      perView = perViewFor(window.innerWidth);
      offset = (perView - 1) / 2;
      track.innerHTML = "";
      // clones for a seamless infinite loop
      for (var i = total - perView; i < total; i++)
        track.appendChild(originals[(i + total) % total].cloneNode(true));
      originals.forEach(function (s) {
        track.appendChild(s.cloneNode(true));
      });
      for (var j = 0; j < perView; j++)
        track.appendChild(originals[j].cloneNode(true));
      position(false);
      paintDots();
    }

    function slides() {
      return $$(".tslide", track);
    }

    function position(animate) {
      var trackIndex = index + perView;
      track.style.transition = animate ? "" : "none";
      track.style.transform =
        "translateX(" + -(trackIndex - offset) * (100 / perView) + "%)";
      if (!animate) {
        void track.offsetWidth;
        track.style.transition = "";
      }
      slides().forEach(function (s, i) {
        s.classList.toggle("is-active", i === trackIndex);
      });
      $$("button", dotsWrap).forEach(function (d, i) {
        d.setAttribute(
          "aria-current",
          String(i === ((index % total) + total) % total),
        );
      });
    }

    function go(dir) {
      if (animating) return;
      animating = true;
      index += dir;
      position(true);
      window.setTimeout(
        function () {
          if (index >= total) {
            index -= total;
            position(false);
          } else if (index < 0) {
            index += total;
            position(false);
          }
          animating = false;
        },
        reduceMotion ? 0 : 700,
      );
    }

    function jump(i) {
      if (!animating) {
        index = i;
        position(true);
      }
    }

    function paintDots() {
      if (dotsWrap.children.length === total) return;
      dotsWrap.innerHTML = "";
      originals.forEach(function (_, i) {
        var b = document.createElement("button");
        b.type = "button";
        b.setAttribute("aria-label", "Go to story " + (i + 1));
        b.addEventListener("click", function () {
          jump(i);
          restart();
        });
        dotsWrap.appendChild(b);
      });
    }

    function start() {
      if (!timer && !reduceMotion)
        timer = window.setInterval(function () {
          go(1);
        }, 5000);
    }
    function stop() {
      window.clearInterval(timer);
      timer = null;
    }
    function restart() {
      stop();
      start();
    }

    $(".tcar__nav--prev", root).addEventListener("click", function () {
      go(-1);
      restart();
    });
    $(".tcar__nav--next", root).addEventListener("click", function () {
      go(1);
      restart();
    });

    // pause on hover / focus, and when the tab is hidden
    root.addEventListener("mouseenter", stop);
    root.addEventListener("mouseleave", start);
    root.addEventListener("focusin", stop);
    root.addEventListener("focusout", start);
    document.addEventListener("visibilitychange", function () {
      document.hidden ? stop() : start();
    });

    // touch / pointer swipe
    var startX = null;
    var vp = $(".tcar__viewport", root);
    vp.addEventListener("pointerdown", function (e) {
      startX = e.clientX;
      stop();
    });
    vp.addEventListener("pointerup", function (e) {
      if (startX === null) return;
      var dx = e.clientX - startX;
      if (Math.abs(dx) > 45) go(dx < 0 ? 1 : -1);
      startX = null;
      start();
    });
    vp.addEventListener("pointercancel", function () {
      startX = null;
      start();
    });

    var rt;
    window.addEventListener("resize", function () {
      window.clearTimeout(rt);
      rt = window.setTimeout(function () {
        if (perViewFor(window.innerWidth) !== perView) build();
        else position(false);
      }, 180);
    });

    build();
    start();
  })();

  /* ---------- 09. APP SCREEN CAROUSEL ---------- */
  (function phones() {
    var stage = $("#phones");
    if (!stage) return;
    var items = $$(".phone", stage),
      n = items.length,
      active = 0;

    function paint() {
      items.forEach(function (p, i) {
        var d = i - active;
        if (d > n / 2) d -= n;
        if (d < -n / 2) d += n;
        p.setAttribute("data-pos", Math.abs(d) <= 2 ? String(d) : "hide");
      });
    }
    paint();
    if (reduceMotion) return;

    var timer = window.setInterval(function () {
      active = (active + 1) % n;
      paint();
    }, 3200);
    stage.addEventListener("mouseenter", function () {
      window.clearInterval(timer);
    });
    items.forEach(function (p, i) {
      p.addEventListener("click", function () {
        active = i;
        paint();
      });
    });
  })();

  /* ---------- 10. FAQ ACCORDION ---------- */
  (function faq() {
    $$(".acc").forEach(function (acc) {
      var btn = $(".acc__btn", acc);
      btn.addEventListener("click", function () {
        var open = acc.classList.contains("is-open");
        $$(".acc").forEach(function (o) {
          o.classList.remove("is-open");
          $(".acc__btn", o).setAttribute("aria-expanded", "false");
        });
        if (!open) {
          acc.classList.add("is-open");
          btn.setAttribute("aria-expanded", "true");
        }
      });
    });
  })();

  /* ---------- 11. ENQUIRY FORM ---------- */
  (function form() {
    var form = $("#enquiryForm");
    if (!form) return;
    var ok = $("#formOk"),
      service = $("#fService");

    // product / investment CTAs prefill the service dropdown
    $$("[data-service]").forEach(function (a) {
      a.addEventListener("click", function () {
        var want = a.getAttribute("data-service");
        var match = $$("option", service).filter(function (o) {
          return o.value === want || o.textContent === want;
        })[0];
        if (match) service.value = match.value || match.textContent;
        service.closest(".field").classList.remove("is-invalid");
      });
    });

    var rules = {
      fName: function (v) {
        return v.trim().length >= 2;
      },
      fPhone: function (v) {
        return /^[6-9]\d{9}$/.test(
          v.replace(/[^\d]/g, "").replace(/^91(?=\d{10}$)/, ""),
        );
      },
      fEmail: function (v) {
        return /^[^\s@]+@[^\s@]+\.[a-z]{2,}$/i.test(v.trim());
      },
      fService: function (v) {
        return v !== "";
      },
    };

    function validate(id) {
      var input = document.getElementById(id);
      var field = input.closest(".field");
      var valid = rules[id](input.value);
      field.classList.toggle("is-invalid", !valid);
      return valid;
    }

    Object.keys(rules).forEach(function (id) {
      var input = document.getElementById(id);
      input.addEventListener("blur", function () {
        if (input.value) validate(id);
      });
      input.addEventListener("input", function () {
        input.closest(".field").classList.remove("is-invalid");
      });
    });

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var valid = Object.keys(rules).map(validate).every(Boolean);
      if (!valid) {
        var first = $(
          ".field.is-invalid .input, .field.is-invalid .select",
          form,
        );
        if (first) first.focus();
        return;
      }

      var submitBtn = $("button[type=submit]", form);
      if (submitBtn) submitBtn.disabled = true;

      var tokenEl = document.querySelector('meta[name="csrf-token"]');
      fetch(form.action, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": tokenEl ? tokenEl.getAttribute("content") : "",
        },
        body: new FormData(form),
      })
        .then(function (res) {
          if (res.ok) return res.json().catch(function () { return {}; });
          return res.json().then(function (data) {
            throw data;
          });
        })
        .then(function () {
          ok.classList.add("is-shown");
          form.reset();
          window.setTimeout(function () {
            ok.classList.remove("is-shown");
          }, 8000);
        })
        .catch(function (data) {
          var errs = (data && data.errors) || {};
          var map = { name: "fName", phone: "fPhone", email: "fEmail", service: "fService" };
          Object.keys(map).forEach(function (key) {
            var field = document.getElementById(map[key]);
            if (!field) return;
            var wrap = field.closest(".field");
            if (errs[key] || errs.phone_normalised) {
              // phone errors arrive under phone_normalised
            }
            wrap.classList.toggle(
              "is-invalid",
              !!(errs[key] || (key === "phone" && errs.phone_normalised)),
            );
          });
        })
        .finally(function () {
          if (submitBtn) submitBtn.disabled = false;
        });
    });
  })();

  /* ---------- 12. FLOATING MASCOT ASSISTANT WITH SCROLL ANIMATION ---------- */
  (function fab() {
    var fab = $("#fab"),
      btn = $("#fabBtn");
    if (!fab || !btn) return;
    var hoverable = window.matchMedia("(hover: hover)").matches;

    var open = function (state) {
      fab.classList.toggle("is-open", state);
      btn.setAttribute("aria-expanded", String(state));
    };

    if (hoverable) {
      fab.addEventListener("mouseenter", function () {
        open(true);
      });
      fab.addEventListener("mouseleave", function () {
        open(false);
      });
    }
    btn.addEventListener("click", function () {
      open(!fab.classList.contains("is-open"));
    });
    fab.addEventListener("focusin", function () {
      open(true);
    });
    document.addEventListener("click", function (e) {
      if (!fab.contains(e.target)) open(false);
    });
    $$(".fab__item", fab).forEach(function (a) {
      a.addEventListener("click", function () {
        open(false);
      });
    });

    /* Scroll-driven canvas animation on the fixed corner mascot */
    var canvas = $("#scrollAnimCanvas", btn);
    if (!canvas) return;
    var ctx = canvas.getContext("2d");
    var TOTAL_FRAMES = 300;
    var frames = new Array(TOTAL_FRAMES + 1);
    var loadedFrames = new Set();
    var currentRendered = 1,
      currentFloat = 1,
      targetFrame = 1,
      rafId = null;

    function getFrameUrl(i) {
      var pad = ("000" + i).slice(-3);
      return "/assets/img/scrolling_animation/ezgif-frame-" + pad + ".webp";
    }

    function loadFrame(i, cb) {
      if (frames[i]) {
        if (loadedFrames.has(i) && cb) cb();
        return;
      }
      var img = new Image();
      img.src = getFrameUrl(i);
      frames[i] = img;
      img.onload = function () {
        loadedFrames.add(i);
        if (cb) cb();
      };
    }

    function drawFrame(index) {
      if (!ctx) return;
      var img = frames[index];
      if (!img || !img.complete || img.naturalWidth === 0) {
        var bestDist = Infinity,
          bestIdx = 1;
        for (var i = 1; i <= TOTAL_FRAMES; i++) {
          if (loadedFrames.has(i)) {
            var d = Math.abs(i - index);
            if (d < bestDist) {
              bestDist = d;
              bestIdx = i;
            }
          }
        }
        img = frames[bestIdx];
      }
      if (!img || !img.complete || img.naturalWidth === 0) return;
      currentRendered = index;

      var cw = canvas.width,
        ch = canvas.height;
      ctx.clearRect(0, 0, cw, ch);
      var iw = img.naturalWidth,
        ih = img.naturalHeight;
      // Contain scaling: full mascot character is 100% visible with zero cropping
      var scale = Math.min(cw / iw, ch / ih);
      var dw = iw * scale,
        dh = ih * scale;
      var dx = (cw - dw) / 2,
        dy = (ch - dh) / 2;
      ctx.drawImage(img, dx, dy, dw, dh);
    }

    function resize() {
      var dpr = Math.min(window.devicePixelRatio || 1, 2);
      var rect = canvas.getBoundingClientRect();
      var w = rect.width || 168,
        h = rect.height || 205;
      canvas.width = Math.round(w * dpr);
      canvas.height = Math.round(h * dpr);
      drawFrame(currentRendered);
    }

    function updateProgress() {
      var docH = document.documentElement.scrollHeight - window.innerHeight;
      var p = docH > 0 ? window.scrollY / docH : 0;
      p = Math.max(0, Math.min(1, p));
      targetFrame = Math.max(
        1,
        Math.min(TOTAL_FRAMES, Math.round(1 + p * (TOTAL_FRAMES - 1))),
      );
    }

    function loop() {
      var diff = targetFrame - currentFloat;
      if (reduceMotion) {
        currentFloat = targetFrame;
      } else if (Math.abs(diff) > 0.05) {
        currentFloat += diff * 0.18;
      } else {
        currentFloat = targetFrame;
      }
      var idx = Math.max(1, Math.min(TOTAL_FRAMES, Math.round(currentFloat)));
      if (idx !== currentRendered || diff !== 0) {
        drawFrame(idx);
      }
      if (!reduceMotion && Math.abs(diff) > 0.05) {
        rafId = requestAnimationFrame(loop);
      } else {
        rafId = null;
      }
    }

    function onScroll() {
      updateProgress();
      if (!rafId) rafId = requestAnimationFrame(loop);
    }

    loadFrame(1, function () {
      btn.classList.add("has-canvas");
      resize();
      drawFrame(1);
    });

    // Keyframes + background loading
    var queue = [];
    for (var k = 1; k <= TOTAL_FRAMES; k += 5) queue.push(k);
    for (var r = 1; r <= TOTAL_FRAMES; r++) {
      if (r % 5 !== 1) queue.push(r);
    }

    var active = 0;
    function pump() {
      while (active < 4 && queue.length > 0) {
        var next = queue.shift();
        if (loadedFrames.has(next)) continue;
        active++;
        (function (n) {
          loadFrame(n, function () {
            active--;
            if (Math.abs(n - targetFrame) < 3) drawFrame(n);
            pump();
          });
        })(next);
      }
    }
    setTimeout(pump, 150);

    window.addEventListener("scroll", onScroll, { passive: true });
    window.addEventListener("resize", function () {
      resize();
      onScroll();
    });
    resize();
    onScroll();
  })();

  /* ---------- 12b. SIDE MASCOT — SOCIAL LINKS ---------- */
  (function sideMascot() {
    var root = $("#sideMascot"),
      btn = $("#sideMascotBtn");
    if (!root || !btn) return;
    var hoverable = window.matchMedia("(hover: hover)").matches;
    var timer = null;

    var open = function (state) {
      clearTimeout(timer);
      root.classList.toggle("is-open", state);
      btn.setAttribute("aria-expanded", String(state));
    };
    /* grace period so the pointer can cross the gap to the icons */
    var closeSoon = function () {
      clearTimeout(timer);
      timer = setTimeout(function () {
        open(false);
      }, 240);
    };

    if (hoverable) {
      root.addEventListener("mouseenter", function () {
        open(true);
      });
      root.addEventListener("mouseleave", closeSoon);
    }
    btn.addEventListener("click", function () {
      open(!root.classList.contains("is-open"));
    });
    root.addEventListener("focusin", function () {
      open(true);
    });
    document.addEventListener("click", function (e) {
      if (!root.contains(e.target)) open(false);
    });
    $$(".smascot__item", root).forEach(function (a) {
      a.addEventListener("click", function () {
        open(false);
      });
    });
  })();

  /* ---------- 12c. INVESTMENT TIMELINE (tabs) ---------- */
  (function investTimeline() {
    var root = $(".invtl");
    if (!root) return;
    var tabs = $$(".invtl__step", root),
      panels = $$(".invtl__panel", root);
    if (tabs.length !== panels.length || !tabs.length) return;

    function select(i) {
      tabs.forEach(function (t, n) {
        t.classList.toggle("is-active", n === i);
        t.setAttribute("aria-selected", String(n === i));
        t.tabIndex = n === i ? 0 : -1;
      });
      panels.forEach(function (p, n) {
        p.hidden = n !== i;
      });
    }

    tabs.forEach(function (t, i) {
      t.addEventListener("click", function () {
        select(i);
      });
      t.addEventListener("keydown", function (e) {
        var d = e.key === "ArrowRight" ? 1 : e.key === "ArrowLeft" ? -1 : 0;
        if (!d) return;
        e.preventDefault();
        var n = (i + d + tabs.length) % tabs.length;
        select(n);
        tabs[n].focus();
      });
    });
    select(0);
  })();

  /* ---------- 13. BRANCH SEARCH ---------- */
  (function branches() {
    var input = $("#branchSearch"),
      list = $("#branchList"),
      empty = $("#branchEmpty");
    if (!input || !list) return;
    var cards = $$("[data-branch]", list);

    input.addEventListener("input", function () {
      var q = input.value.trim().toLowerCase();
      var shown = 0;
      cards.forEach(function (card) {
        var hay = (
          card.getAttribute("data-branch") +
          " " +
          card.textContent
        ).toLowerCase();
        var hit = !q || hay.indexOf(q) > -1;
        card.style.display = hit ? "" : "none";
        if (hit) shown++;
      });
      empty.style.display = shown ? "none" : "block";
    });
  })();

  /* ---------- 14. BACK TO TOP + YEAR ---------- */
  (function misc() {
    var top = $("#toTop");
    window.addEventListener(
      "scroll",
      function () {
        top.classList.toggle("is-shown", window.scrollY > 600);
      },
      { passive: true },
    );
    top.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: reduceMotion ? "auto" : "smooth" });
    });
    $("#year").textContent = new Date().getFullYear();
  })();

  /* ---------- 16. ?service= PREFILL (product CTAs land on the form ready to go) ---------- */
  (function servicePrefill() {
    var sel = $("#fService");
    if (!sel) return;
    var m = /[?&]service=([^&]*)/.exec(window.location.search);
    if (!m) return;
    var want = decodeURIComponent(m[1].replace(/\+/g, " "));
    var exists = $$("option", sel).some(function (o) {
      return o.value === want;
    });
    if (!exists) return;
    sel.value = want;
    var field = sel.closest(".field");
    if (field) field.classList.remove("is-invalid");
    var form = $("#enquiryForm");
    if (form)
      window.setTimeout(function () {
        form.scrollIntoView({
          behavior: reduceMotion ? "auto" : "smooth",
          block: "center",
        });
      }, 400);
  })();

  /* ---------- 17. EVENT GALLERY SLIDESHOW ---------- */
  (function gallery() {
    var root = $("#gallery");
    if (!root) return;
    var items = $$(".gallery__item", root),
      dots = $(".gallery__dots", root),
      i = 0,
      timer = null;

    function paint() {
      items.forEach(function (el, k) {
        el.classList.toggle("is-active", k === i);
      });
      $$("button", dots).forEach(function (d, k) {
        d.setAttribute("aria-current", String(k === i));
      });
    }
    function go(d) {
      i = (i + d + items.length) % items.length;
      paint();
    }
    function start() {
      if (!timer && !reduceMotion)
        timer = window.setInterval(function () {
          go(1);
        }, 5000);
    }
    function stop() {
      window.clearInterval(timer);
      timer = null;
    }
    function restart() {
      stop();
      start();
    }

    items.forEach(function (_, k) {
      var b = document.createElement("button");
      b.type = "button";
      b.setAttribute("aria-label", "Show image " + (k + 1));
      b.addEventListener("click", function () {
        i = k;
        paint();
        restart();
      });
      dots.appendChild(b);
    });

    $(".gallery__nav--prev", root).addEventListener("click", function () {
      go(-1);
      restart();
    });
    $(".gallery__nav--next", root).addEventListener("click", function () {
      go(1);
      restart();
    });
    root.addEventListener("mouseenter", stop);
    root.addEventListener("mouseleave", start);
    document.addEventListener("visibilitychange", function () {
      document.hidden ? stop() : start();
    });

    paint();
    start();
  })();

  /* ---------- 18. INTEREST RATE CARDS ---------- */
  (function rateCards() {
    $$(".rate").forEach(function (card) {
      var head = $(".rate__head", card);
      var toggle = function () {
        var open = card.classList.toggle("is-open");
        head.setAttribute("aria-expanded", String(open));
      };
      head.setAttribute("role", "button");
      head.setAttribute("tabindex", "0");
      head.setAttribute("aria-expanded", "false");
      head.addEventListener("click", toggle);
      head.addEventListener("keydown", function (e) {
        if (e.key === "Enter" || e.key === " ") {
          e.preventDefault();
          toggle();
        }
      });
    });
  })();

  /* ---------- 19. MODALS ---------- */
  (function modals() {
    var modals = $$(".modal");
    if (!modals.length) return;
    var opener = null;

    function open(m) {
      opener = document.activeElement;
      m.classList.add("is-open");
      document.body.style.overflow = "hidden";
      var first = $(".modal__close", m);
      if (first) first.focus();
    }
    function close(m) {
      m.classList.remove("is-open");
      document.body.style.overflow = "";
      if (opener && opener.focus) opener.focus();
    }

    $$("[data-modal-open]").forEach(function (btn) {
      btn.addEventListener("click", function () {
        var m = document.getElementById(btn.getAttribute("data-modal-open"));
        if (m) open(m);
      });
    });
    modals.forEach(function (m) {
      $$("[data-modal-close]", m).forEach(function (b) {
        b.addEventListener("click", function () {
          close(m);
        });
      });
      m.addEventListener("click", function (e) {
        if (e.target === m) close(m);
      });
    });
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape") $$(".modal.is-open").forEach(close);
    });
  })();

  /* ---------- 20. JOB APPLICATION FORM ---------- */
  (function applyForm() {
    var form = $("#applyForm");
    if (!form) return;
    var cv = $("#aCv"),
      cvName = $("#aCvName"),
      ok = $("#applyOk");
    var MAX = 5 * 1024 * 1024;
    var placeholder = cvName.textContent;

    cv.addEventListener("change", function () {
      var f = cv.files && cv.files[0];
      cvName.textContent = f
        ? f.name + " · " + Math.max(1, Math.round(f.size / 1024)) + " KB"
        : placeholder;
      cv.closest(".field").classList.remove("is-invalid");
    });

    var rules = {
      aName: function (v) {
        return v.trim().length >= 2;
      },
      aEmail: function (v) {
        return /^[^\s@]+@[^\s@]+\.[a-z]{2,}$/i.test(v.trim());
      },
      aPhone: function (v) {
        return /^[6-9]\d{9}$/.test(
          v.replace(/[^\d]/g, "").replace(/^91(?=\d{10}$)/, ""),
        );
      },
    };

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var valid = true;
      Object.keys(rules).forEach(function (id) {
        var el = document.getElementById(id);
        var good = rules[id](el.value);
        el.closest(".field").classList.toggle("is-invalid", !good);
        if (!good) valid = false;
      });
      var file = cv.files && cv.files[0];
      var goodFile = !!file && file.size <= MAX;
      cv.closest(".field").classList.toggle("is-invalid", !goodFile);
      if (!goodFile) valid = false;
      if (!valid) return;

      var submitBtn = $("button[type=submit]", form);
      if (submitBtn) submitBtn.disabled = true;

      var tokenEl = document.querySelector('meta[name="csrf-token"]');
      fetch(form.action, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": tokenEl ? tokenEl.getAttribute("content") : "",
        },
        body: new FormData(form),
      })
        .then(function (res) {
          if (res.ok) return res.json().catch(function () { return {}; });
          return res.json().then(function (data) {
            throw data;
          });
        })
        .then(function () {
          ok.classList.add("is-shown");
          form.reset();
          cvName.textContent = placeholder;
          window.setTimeout(function () {
            ok.classList.remove("is-shown");
          }, 8000);
        })
        .catch(function (data) {
          var errs = (data && data.errors) || {};
          var map = { aName: "name", aEmail: "email", aPhone: "phone_normalised", aCv: "cv" };
          Object.keys(map).forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.closest(".field").classList.toggle("is-invalid", !!errs[map[id]]);
          });
        })
        .finally(function () {
          if (submitBtn) submitBtn.disabled = false;
        });
    });
  })();
})();
