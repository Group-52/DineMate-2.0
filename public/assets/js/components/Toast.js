class Toast {
  /**
   * Creates a floating toast with icon and message
   * @param iconClassName Font Awesome Icon Classname
   * @param iconColor Font Awesome Icon Color
   * @param title Title of message
   * @param message Message Content
   * @param closable Boolean if toast can be closed
   * @param duration Length of time (in ms) before the toast is closed automatically
   */
  constructor(iconClassName, iconColor, title, message, closable, duration = null) {
    this.icon = iconClassName;
    this.iconColor = iconColor;
    this.title = title;
    this.message = message;
    this.closable = closable;
    this.duration = duration;

    this.show();
  }

  createToastContainer() {
    let toastContainer = document.querySelector('#toast-container')
    if (toastContainer == null) {
      toastContainer = document.createElement('div');
      toastContainer.id = 'toast-container';
      toastContainer.className = 'toast-container d-flex flex-column align-items-center justify-content-end';
      document.body.appendChild(toastContainer);
    }
    return toastContainer;
  }

  createToast() {
    const toast = document.createElement('div');
    toast.className = 'toast p-4 d-flex align-items-center rounded-sm shadow-sm';

    if (this.icon != null) {
      const toastIcon = document.createElement('i');
      toastIcon.className = 'toast-icon mr-4 ' + this.icon;
      toastIcon.style.color = this.iconColor || "black";
      toast.appendChild(toastIcon);
    }

    const toastContent = document.createElement('div');
    toastContent.className = 'toast-content';
    toast.appendChild(toastContent);

    if (this.title != null) {
      const toastTitle = document.createElement('div');
      toastTitle.className = 'toast-title display-6 uppercase';
      toastTitle.innerText = this.title;
      toastContent.appendChild(toastTitle);
    }

    if (this.message != null) {
      const toastMessage = document.createElement('div');
      toastMessage.classList.add('toast-content');
      toastMessage.innerText = this.message;
      toastContent.appendChild(toastMessage);
    }

    if (this.closable) {
      const toastClose = document.createElement('i');
      toastClose.className = "toast-close fa-solid fa-xmark";
      toastClose.onclick = () => {
        this.hide();
      }
      toast.appendChild(toastClose);
    }

    this.createToastContainer().appendChild(toast);
    this.toast = toast;
  }

  show() {
    this.createToast();
    if (this.duration != null) {
      setTimeout(() => {
        this.hide();
      }, this.duration);
    }
  }

  hide() {
    this.toast.remove();
  }
}