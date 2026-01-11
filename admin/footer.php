<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      
    </div>
    <strong>All Copyright &copy; 2021-<?php echo date('Y'); ?> <a href="javascript:void(0);">Shopercity</a>.</strong> All rights reserved.
  </footer>
  <div class="toasts-containers"></div>
  <style>
    .toasts-container {
    position: fixed;
    top: 25px;
    right: 30px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 100000;
  }
  
  .toasts {
    z-index: 10000;
    position: absolute;
    top:10px;
    right: 5px;
    width: 320px;
    border-radius: 12px;
    background: #fff;
    padding: 20px 35px 20px 25px;
    box-shadow: 0 6px 20px -5px rgba(0, 0, 0, 0.1);
    display: flex;
    overflow-x: hidden;
    align-items: center;
    transform: translateX(calc(100% + 30px));
    transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.35);
  }
  
  .toasts.active {
    transform: translateX(0%);
  }
  
  .toasts .toasts-content {
    display: flex;
    align-items: center;
  }
  
  .toasts-content .icon {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 35px;
    min-width: 35px;
    font-size: 35px;
    color: #fff;
  }
  
  .toasts-content .message {
    display: flex;
    flex-direction: column;
    margin-left: 15px;
  }
  
  .message .text {
    font-size: 16px;
    font-weight: 400;
    color: #666666;
    font-family: "Outfit", serif;
    font-optical-sizing: auto;
    font-style: normal;
  }
  
  .message .text.text-1 {
    font-weight: 600;
    color: #333;
  }
  
  .toasts .close {
    position: absolute;
    top: 10px;
    right: 15px;
    padding: 5px;
    cursor: pointer;
    opacity: 0.7;
  }
  
  .toasts .close:hover {
    opacity: 1;
  }
  
  .toasts .progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    width: 100%;
  }
  
  .toasts .progress:before {
    content: "";
    position: absolute;
    bottom: 0;
    right: 0;
    height: 100%;
    width: 100%;
    background-color: #4070f4;
  }
  
  .progress.active:before {
    animation: progress 5s linear forwards;
  }
  
  @keyframes progress {
    100% {
      right: 100%;
    }
  }
  
  /* Toast Type Colors */
  .toasts.success .icon { color: rgb(25 135 84); }
  .toasts.error .icon { color: rgb(220 53 69); }
  .toasts.warning .icon { color: rgb(255 193 7); }
  .toasts.info .icon { color: rgb(13 202 240); }
  
  .toasts.success .progress:before { background: rgb(25 135 84); }
  .toasts.error .progress:before { background: rgb(220 53 69); }
  .toasts.warning .progress:before { background: rgb(255 193 7); }
  .toasts.info .progress:before { background: rgb(13 202 240); }
  </style>
  <script>
    function showToast(message, type = "success") {
  const toastContainer = document.querySelector(".toasts-containers");

  const toast = document.createElement("div");
  toast.classList.add("toasts", type);

  toast.innerHTML = `
    <div class="toasts-content">
      <div class="message">
        <span class="text text-1">${capitalize(type)}</span>
        <span class="text text-2">${message}</span>
      </div>
    </div>
    <span class="close">X</span>
    <div class="progress active"></div>
  `;

  toastContainer.appendChild(toast);
  let showToast = setTimeout(() => {
    void toast.offsetHeight;
    toast.classList.add("active");
  }, 1);

  const progress = toast.querySelector(".progress");
  const closeIcon = toast.querySelector(".close");

  // Auto-remove toast after 5s
  const timer1 = setTimeout(() => {
    toast.classList.remove("active");
  }, 5000);

  const timer2 = setTimeout(() => {
    progress.classList.remove("active");
    setTimeout(() => toast.remove(), 400);
  }, 5300);

  // Manual close
  closeIcon.addEventListener("click", () => {
    toast.classList.remove("active");
    clearTimeout(timer1);
    clearTimeout(timer2);
    clearTimeout(showToast);
    setTimeout(() => toast.remove(), 400);
  });
}

function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

// Example Usage:
<?php
if(isset($_SESSION['ins_msg'])){
  ?>
showToast("<?php echo $_SESSION['ins_msg']; ?>", "success");
<?php
unset($_SESSION['ins_msg']);
} else if(isset($_SESSION['err'])) {
  ?>
setTimeout(() => showToast("Something went wrong!", "error"), 1000);
<?php
unset($_SESSION['err']);
}
?>
</script>