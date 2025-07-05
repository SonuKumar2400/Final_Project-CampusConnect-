setTimeout(() => {
  const errorMsg = document.querySelector('.error');
  if (errorMsg) {
    errorMsg.style.transition = 'opacity 0.5s ease';
    errorMsg.style.opacity = '0';
    setTimeout(() => errorMsg.remove(), 500);
  }
}, 3000);

document.addEventListener("DOMContentLoaded", () => {
  const buttons = document.querySelectorAll(".btn");

  buttons.forEach((btn) => {
    btn.addEventListener("mouseenter", () => {
      btn.style.boxShadow = "0 0 8px rgba(0, 123, 255, 0.6)";
    });

    btn.addEventListener("mouseleave", () => {
      btn.style.boxShadow = "none";
    });

    btn.addEventListener("click", function (e) {
      const ripple = document.createElement("span");
      ripple.className = "ripple";
      this.appendChild(ripple);

      const size = Math.max(this.offsetWidth, this.offsetHeight);
      ripple.style.width = ripple.style.height = size + 'px';
      ripple.style.left = (e.offsetX - size / 2) + 'px';
      ripple.style.top = (e.offsetY - size / 2) + 'px';

      setTimeout(() => ripple.remove(), 500);
    });
  });
});

// 3. Scroll to top on each page load
window.onload = () => {
  window.scrollTo(0, 0);
};

document.querySelectorAll('form').forEach(form => {
  form.addEventListener('submit', () => {
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.innerText = "Please wait...";
    }
  });
});
