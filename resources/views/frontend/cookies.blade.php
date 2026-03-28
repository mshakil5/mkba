<style>
  /* --- Professional Cookie Banner Styling --- */
  #cookie {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%) translateY(150%);
    width: 90%;
    max-width: 600px;
    z-index: 10000;
    background-color: #ffffff;
    border-radius: 20px;
    box-shadow: 0 15px 50px rgba(0, 104, 74, 0.15); /* Subtle green-tinted shadow */
    padding: 25px;
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    border: 1px solid rgba(0, 104, 74, 0.1);
  }

  #cookie.active {
    transform: translateX(-50%) translateY(0);
  }

  .cookie-title {
    color: #ff4d4d; /* Brand Red Accent */
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    display: block;
    margin-bottom: 8px;
  }

  .cookie-heading {
    color: #0a1d37; /* Brand Dark Navy */
    font-weight: 800;
    font-size: 1.25rem;
    margin-bottom: 12px;
  }

  .cookie-text {
    color: #5e6d82;
    font-size: 0.9rem;
    line-height: 1.6;
  }

  /* Button Styling to match "View All Events" */
  .btn-accept {
    background-color: #00684a;
    color: #ffffff;
    border: 2px solid #00684a;
    font-weight: 700;
    padding: 10px 30px;
    transition: 0.3s;
  }

  .btn-accept:hover {
    background-color: #004d36;
    border-color: #004d36;
    color: #ffffff;
    transform: translateY(-2px);
  }

  .btn-settings {
    color: #00684a;
    font-weight: 700;
    text-decoration: none;
    font-size: 0.9rem;
    margin-left: 15px;
  }

  /* Mobile Adjustments */
  @media (max-width: 768px) {
    #cookie {
      bottom: 20px;
      padding: 20px;
    }
    .cookie-buttons {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    .btn-settings {
      margin-left: 0;
      text-align: center;
    }
  }
</style>

<section id="cookie" class="cookie-consent-banner">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-12">
        <span class="cookie-title">Cookie Policy</span>
        <h5 class="cookie-heading">We value your privacy</h5>
        <p class="cookie-text">
          We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. By clicking "Accept", you consent to our use of cookies.
        </p>
        <div class="cookie-buttons mt-4 d-flex align-items-center">
          <button class="btn btn-accept rounded-pill shadow-sm" onclick="acceptCookies()">Accept All</button>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function setCookie(name, value, days) {
    let expires = "";
    if (days) {
      const date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
  }

  function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i].trim();
      if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length);
    }
    return null;
  }

  function acceptCookies() {
    setCookie('cookie_consent', 'accepted', 365);
    hideCookieBanner();
  }

  function showCookieBanner() {
    document.getElementById('cookie').classList.add('active');
  }

  function hideCookieBanner() {
    document.getElementById('cookie').classList.remove('active');
  }

  document.addEventListener('DOMContentLoaded', function () {
    // Show banner after 2 seconds for a more professional entry
    if (!getCookie('cookie_consent')) {
      setTimeout(showCookieBanner, 2000);
    }
  });
</script>