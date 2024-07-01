// resources/js/modal.js
window.scribbleModal = () => {
  return {
    show: false,
    showActiveComponent: true,
    activeComponent: false,
    componentHistory: [],
    modalWidth: null,
    modalAlignment: null,
    isSlideOver: false,
    slideDirection: "right",
    listeners: [],
    getActiveComponentModalAttribute(key) {
      if (this.$wire.get("components")[this.activeComponent] !== void 0) {
        return this.$wire.get("components")[this.activeComponent]["modalAttributes"][key];
      }
    },
    closeModalOnEscape() {
      if (this.getActiveComponentModalAttribute("closeOnEscape") === false) {
        return;
      }
      let force = this.getActiveComponentModalAttribute("closeOnEscapeIsForceful") === true;
      this.closeScribbleModal(force);
    },
    closeModalOnClickAway() {
      if (this.getActiveComponentModalAttribute("closeOnClickAway") === false) {
        return;
      }
      this.closeScribbleModal(true);
    },
    closeScribbleModal(force = false, skipPreviousModals = 0, destroySkipped = false) {
      if (this.show === false) {
        return;
      }
      if (this.getActiveComponentModalAttribute("dispatchCloseEvent") === true) {
        const componentName = this.$wire.get("components")[this.activeComponent].name;
        Livewire.dispatch("scribbleModalClosed", { name: componentName });
      }
      if (this.getActiveComponentModalAttribute("destroyOnClose") === true) {
        Livewire.dispatch("destroyScribbleComponent", { id: this.activeComponent });
      }
      if (skipPreviousModals > 0) {
        for (let i = 0; i < skipPreviousModals; i++) {
          if (destroySkipped) {
            const id2 = this.componentHistory[this.componentHistory.length - 1];
            Livewire.dispatch("destroyScribbleComponent", { id: id2 });
          }
          this.componentHistory.pop();
        }
      }
      const id = this.componentHistory.pop();
      if (id && !force) {
        if (id) {
          this.setActiveModalComponent(id, true);
        } else {
          this.setShowPropertyTo(false);
        }
      } else {
        this.setShowPropertyTo(false);
      }
    },
    setActiveModalComponent(id, skip = false) {
      this.setShowPropertyTo(true);
      if (this.activeComponent === id) {
        return;
      }
      if (this.activeComponent !== false && skip === false) {
        this.componentHistory.push(this.activeComponent);
      }
      let focusableTimeout = 50;
      if (this.activeComponent === false) {
        this.activeComponent = id;
        this.showActiveComponent = true;
        this.initializeComponent();
      } else {
        this.showActiveComponent = false;
        focusableTimeout = 400;
        setTimeout(() => {
          this.activeComponent = id;
          this.showActiveComponent = true;
          this.initializeComponent();
        }, 300);
      }
      this.$nextTick(() => {
        let focusable = this.$refs[id]?.querySelector("[autofocus]");
        if (focusable) {
          setTimeout(() => {
            focusable.focus();
          }, focusableTimeout);
        }
      });
    },
    initializeComponent() {
      this.modalWidth = this.getActiveComponentModalAttribute("maxWidth");
      this.modalAlignment = this.getActiveComponentModalAttribute("alignment");
      this.isSlideOver = this.getActiveComponentModalAttribute("isSlideOver");
      this.slideDirection = this.getActiveComponentModalAttribute("slideDirection");
    },
    focusables() {
      let selector = "a, button, input:not([type='hidden'], textarea, select, details, [tabindex]:not([tabindex='-1'])";
      return [...this.$el.querySelectorAll(selector)].filter((el) => !el.hasAttribute("disabled"));
    },
    firstFocusable() {
      return this.focusables()[0];
    },
    lastFocusable() {
      return this.focusables().slice(-1)[0];
    },
    nextFocusable() {
      return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable();
    },
    prevFocusable() {
      return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable();
    },
    nextFocusableIndex() {
      return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1);
    },
    prevFocusableIndex() {
      return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1;
    },
    setShowPropertyTo(show) {
      this.show = show;
      if (show) {
        document.body.classList.add("overflow-y-hidden");
      } else {
        document.body.classList.remove("overflow-y-hidden");
        setTimeout(() => {
          this.activeComponent = false;
          this.$wire.resetState();
        }, 300);
      }
    },
    init() {
      this.initializeComponent();
      this.listeners.push(
        Livewire.on("closeScribbleModal", (data) => {
          this.closeScribbleModal(data?.force ?? false, data?.skipPreviousModals ?? 0, data?.destroySkipped ?? false);
        })
      );
      this.listeners.push(
        Livewire.on("activeScribbleModalComponentChanged", ({ id }) => {
          this.setActiveModalComponent(id);
        })
      );
    },
    destroy() {
      this.listeners.forEach((listener) => {
        listener();
      });
    }
  };
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsiLi4vanMvbW9kYWwuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbIndpbmRvdy5zY3JpYmJsZU1vZGFsID0gKCkgPT4ge1xuICAgIHJldHVybiB7XG4gICAgICAgIHNob3c6IGZhbHNlLFxuICAgICAgICBzaG93QWN0aXZlQ29tcG9uZW50OiB0cnVlLFxuICAgICAgICBhY3RpdmVDb21wb25lbnQ6IGZhbHNlLFxuICAgICAgICBjb21wb25lbnRIaXN0b3J5OiBbXSxcbiAgICAgICAgbW9kYWxXaWR0aDogbnVsbCxcbiAgICAgICAgbW9kYWxBbGlnbm1lbnQ6IG51bGwsXG4gICAgICAgIGlzU2xpZGVPdmVyOiBmYWxzZSxcbiAgICAgICAgc2xpZGVEaXJlY3Rpb246ICdyaWdodCcsXG4gICAgICAgIGxpc3RlbmVyczogW10sXG4gICAgICAgIGdldEFjdGl2ZUNvbXBvbmVudE1vZGFsQXR0cmlidXRlKGtleSkge1xuICAgICAgICAgICAgaWYgKHRoaXMuJHdpcmUuZ2V0KCdjb21wb25lbnRzJylbdGhpcy5hY3RpdmVDb21wb25lbnRdICE9PSB1bmRlZmluZWQpIHtcbiAgICAgICAgICAgICAgICByZXR1cm4gdGhpcy4kd2lyZS5nZXQoJ2NvbXBvbmVudHMnKVt0aGlzLmFjdGl2ZUNvbXBvbmVudF1bJ21vZGFsQXR0cmlidXRlcyddW2tleV1cbiAgICAgICAgICAgIH1cbiAgICAgICAgfSxcbiAgICAgICAgY2xvc2VNb2RhbE9uRXNjYXBlKCkge1xuICAgICAgICAgICAgaWYgKHRoaXMuZ2V0QWN0aXZlQ29tcG9uZW50TW9kYWxBdHRyaWJ1dGUoJ2Nsb3NlT25Fc2NhcGUnKSA9PT0gZmFsc2UpIHtcbiAgICAgICAgICAgICAgICByZXR1cm5cbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgbGV0IGZvcmNlID0gdGhpcy5nZXRBY3RpdmVDb21wb25lbnRNb2RhbEF0dHJpYnV0ZSgnY2xvc2VPbkVzY2FwZUlzRm9yY2VmdWwnKSA9PT0gdHJ1ZTtcbiAgICAgICAgICAgIHRoaXMuY2xvc2VTY3JpYmJsZU1vZGFsKGZvcmNlKVxuICAgICAgICB9LFxuICAgICAgICBjbG9zZU1vZGFsT25DbGlja0F3YXkoKSB7XG4gICAgICAgICAgICBpZiAodGhpcy5nZXRBY3RpdmVDb21wb25lbnRNb2RhbEF0dHJpYnV0ZSgnY2xvc2VPbkNsaWNrQXdheScpID09PSBmYWxzZSkge1xuICAgICAgICAgICAgICAgIHJldHVyblxuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB0aGlzLmNsb3NlU2NyaWJibGVNb2RhbCh0cnVlKVxuICAgICAgICB9LFxuICAgICAgICBjbG9zZVNjcmliYmxlTW9kYWwoZm9yY2UgPSBmYWxzZSwgc2tpcFByZXZpb3VzTW9kYWxzID0gMCwgZGVzdHJveVNraXBwZWQgPSBmYWxzZSkge1xuICAgICAgICAgICAgaWYodGhpcy5zaG93ID09PSBmYWxzZSkge1xuICAgICAgICAgICAgICAgIHJldHVyblxuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZiAodGhpcy5nZXRBY3RpdmVDb21wb25lbnRNb2RhbEF0dHJpYnV0ZSgnZGlzcGF0Y2hDbG9zZUV2ZW50JykgPT09IHRydWUpIHtcbiAgICAgICAgICAgICAgICBjb25zdCBjb21wb25lbnROYW1lID0gdGhpcy4kd2lyZS5nZXQoJ2NvbXBvbmVudHMnKVt0aGlzLmFjdGl2ZUNvbXBvbmVudF0ubmFtZTtcbiAgICAgICAgICAgICAgICBMaXZld2lyZS5kaXNwYXRjaCgnc2NyaWJibGVNb2RhbENsb3NlZCcsIHtuYW1lOiBjb21wb25lbnROYW1lfSlcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgaWYgKHRoaXMuZ2V0QWN0aXZlQ29tcG9uZW50TW9kYWxBdHRyaWJ1dGUoJ2Rlc3Ryb3lPbkNsb3NlJykgPT09IHRydWUpIHtcbiAgICAgICAgICAgICAgICBMaXZld2lyZS5kaXNwYXRjaCgnZGVzdHJveVNjcmliYmxlQ29tcG9uZW50Jywge2lkOiB0aGlzLmFjdGl2ZUNvbXBvbmVudH0pXG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIGlmIChza2lwUHJldmlvdXNNb2RhbHMgPiAwKSB7XG4gICAgICAgICAgICAgICAgZm9yIChsZXQgaSA9IDA7IGkgPCBza2lwUHJldmlvdXNNb2RhbHM7IGkrKykge1xuICAgICAgICAgICAgICAgICAgICBpZiAoZGVzdHJveVNraXBwZWQpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGNvbnN0IGlkID0gdGhpcy5jb21wb25lbnRIaXN0b3J5W3RoaXMuY29tcG9uZW50SGlzdG9yeS5sZW5ndGggLSAxXTtcbiAgICAgICAgICAgICAgICAgICAgICAgIExpdmV3aXJlLmRpc3BhdGNoKCdkZXN0cm95U2NyaWJibGVDb21wb25lbnQnLCB7aWQ6IGlkfSlcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB0aGlzLmNvbXBvbmVudEhpc3RvcnkucG9wKClcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIGNvbnN0IGlkID0gdGhpcy5jb21wb25lbnRIaXN0b3J5LnBvcCgpXG5cbiAgICAgICAgICAgIGlmIChpZCAmJiAhZm9yY2UpIHtcbiAgICAgICAgICAgICAgICBpZiAoaWQpIHtcbiAgICAgICAgICAgICAgICAgICAgdGhpcy5zZXRBY3RpdmVNb2RhbENvbXBvbmVudChpZCwgdHJ1ZSlcbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICB0aGlzLnNldFNob3dQcm9wZXJ0eVRvKGZhbHNlKVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgdGhpcy5zZXRTaG93UHJvcGVydHlUbyhmYWxzZSlcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSxcbiAgICAgICAgc2V0QWN0aXZlTW9kYWxDb21wb25lbnQoaWQsIHNraXAgPSBmYWxzZSkge1xuICAgICAgICAgICAgdGhpcy5zZXRTaG93UHJvcGVydHlUbyh0cnVlKVxuXG4gICAgICAgICAgICBpZiAodGhpcy5hY3RpdmVDb21wb25lbnQgPT09IGlkKSB7XG4gICAgICAgICAgICAgICAgcmV0dXJuXG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIGlmICh0aGlzLmFjdGl2ZUNvbXBvbmVudCAhPT0gZmFsc2UgJiYgc2tpcCA9PT0gZmFsc2UpIHtcbiAgICAgICAgICAgICAgICB0aGlzLmNvbXBvbmVudEhpc3RvcnkucHVzaCh0aGlzLmFjdGl2ZUNvbXBvbmVudClcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgbGV0IGZvY3VzYWJsZVRpbWVvdXQgPSA1MFxuXG4gICAgICAgICAgICBpZiAodGhpcy5hY3RpdmVDb21wb25lbnQgPT09IGZhbHNlKSB7XG4gICAgICAgICAgICAgICAgdGhpcy5hY3RpdmVDb21wb25lbnQgPSBpZFxuICAgICAgICAgICAgICAgIHRoaXMuc2hvd0FjdGl2ZUNvbXBvbmVudCA9IHRydWVcbiAgICAgICAgICAgICAgICB0aGlzLmluaXRpYWxpemVDb21wb25lbnQoKVxuICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICB0aGlzLnNob3dBY3RpdmVDb21wb25lbnQgPSBmYWxzZVxuXG4gICAgICAgICAgICAgICAgZm9jdXNhYmxlVGltZW91dCA9IDQwMFxuXG4gICAgICAgICAgICAgICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgICAgICAgICAgICAgIHRoaXMuYWN0aXZlQ29tcG9uZW50ID0gaWRcbiAgICAgICAgICAgICAgICAgICAgdGhpcy5zaG93QWN0aXZlQ29tcG9uZW50ID0gdHJ1ZVxuICAgICAgICAgICAgICAgICAgICB0aGlzLmluaXRpYWxpemVDb21wb25lbnQoKVxuICAgICAgICAgICAgICAgIH0sIDMwMClcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgdGhpcy4kbmV4dFRpY2soKCkgPT4ge1xuICAgICAgICAgICAgICAgIGxldCBmb2N1c2FibGUgPSB0aGlzLiRyZWZzW2lkXT8ucXVlcnlTZWxlY3RvcignW2F1dG9mb2N1c10nKVxuICAgICAgICAgICAgICAgIGlmIChmb2N1c2FibGUpIHtcbiAgICAgICAgICAgICAgICAgICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgICAgICAgICAgICAgICAgICBmb2N1c2FibGUuZm9jdXMoKVxuICAgICAgICAgICAgICAgICAgICB9LCBmb2N1c2FibGVUaW1lb3V0KVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9LFxuICAgICAgICBpbml0aWFsaXplQ29tcG9uZW50KCkge1xuICAgICAgICAgICAgdGhpcy5tb2RhbFdpZHRoID0gdGhpcy5nZXRBY3RpdmVDb21wb25lbnRNb2RhbEF0dHJpYnV0ZSgnbWF4V2lkdGgnKVxuICAgICAgICAgICAgdGhpcy5tb2RhbEFsaWdubWVudCA9IHRoaXMuZ2V0QWN0aXZlQ29tcG9uZW50TW9kYWxBdHRyaWJ1dGUoJ2FsaWdubWVudCcpXG4gICAgICAgICAgICB0aGlzLmlzU2xpZGVPdmVyID0gdGhpcy5nZXRBY3RpdmVDb21wb25lbnRNb2RhbEF0dHJpYnV0ZSgnaXNTbGlkZU92ZXInKVxuICAgICAgICAgICAgdGhpcy5zbGlkZURpcmVjdGlvbiA9IHRoaXMuZ2V0QWN0aXZlQ29tcG9uZW50TW9kYWxBdHRyaWJ1dGUoJ3NsaWRlRGlyZWN0aW9uJylcbiAgICAgICAgfSxcbiAgICAgICAgZm9jdXNhYmxlcygpIHtcbiAgICAgICAgICAgIGxldCBzZWxlY3RvciA9ICdhLCBidXR0b24sIGlucHV0Om5vdChbdHlwZT1cXCdoaWRkZW5cXCddLCB0ZXh0YXJlYSwgc2VsZWN0LCBkZXRhaWxzLCBbdGFiaW5kZXhdOm5vdChbdGFiaW5kZXg9XFwnLTFcXCddKSdcblxuICAgICAgICAgICAgcmV0dXJuIFsuLi50aGlzLiRlbC5xdWVyeVNlbGVjdG9yQWxsKHNlbGVjdG9yKV1cbiAgICAgICAgICAgICAgICAuZmlsdGVyKGVsID0+ICFlbC5oYXNBdHRyaWJ1dGUoJ2Rpc2FibGVkJykpXG4gICAgICAgIH0sXG4gICAgICAgIGZpcnN0Rm9jdXNhYmxlKCkge1xuICAgICAgICAgICAgcmV0dXJuIHRoaXMuZm9jdXNhYmxlcygpWzBdXG4gICAgICAgIH0sXG4gICAgICAgIGxhc3RGb2N1c2FibGUoKSB7XG4gICAgICAgICAgICByZXR1cm4gdGhpcy5mb2N1c2FibGVzKCkuc2xpY2UoLTEpWzBdXG4gICAgICAgIH0sXG4gICAgICAgIG5leHRGb2N1c2FibGUoKSB7XG4gICAgICAgICAgICByZXR1cm4gdGhpcy5mb2N1c2FibGVzKClbdGhpcy5uZXh0Rm9jdXNhYmxlSW5kZXgoKV0gfHwgdGhpcy5maXJzdEZvY3VzYWJsZSgpXG4gICAgICAgIH0sXG4gICAgICAgIHByZXZGb2N1c2FibGUoKSB7XG4gICAgICAgICAgICByZXR1cm4gdGhpcy5mb2N1c2FibGVzKClbdGhpcy5wcmV2Rm9jdXNhYmxlSW5kZXgoKV0gfHwgdGhpcy5sYXN0Rm9jdXNhYmxlKClcbiAgICAgICAgfSxcbiAgICAgICAgbmV4dEZvY3VzYWJsZUluZGV4KCkge1xuICAgICAgICAgICAgcmV0dXJuICh0aGlzLmZvY3VzYWJsZXMoKS5pbmRleE9mKGRvY3VtZW50LmFjdGl2ZUVsZW1lbnQpICsgMSkgJSAodGhpcy5mb2N1c2FibGVzKCkubGVuZ3RoICsgMSlcbiAgICAgICAgfSxcbiAgICAgICAgcHJldkZvY3VzYWJsZUluZGV4KCkge1xuICAgICAgICAgICAgcmV0dXJuIE1hdGgubWF4KDAsIHRoaXMuZm9jdXNhYmxlcygpLmluZGV4T2YoZG9jdW1lbnQuYWN0aXZlRWxlbWVudCkpIC0gMVxuICAgICAgICB9LFxuICAgICAgICBzZXRTaG93UHJvcGVydHlUbyhzaG93KSB7XG4gICAgICAgICAgICB0aGlzLnNob3cgPSBzaG93XG5cbiAgICAgICAgICAgIGlmIChzaG93KSB7XG4gICAgICAgICAgICAgICAgZG9jdW1lbnQuYm9keS5jbGFzc0xpc3QuYWRkKCdvdmVyZmxvdy15LWhpZGRlbicpXG4gICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgIGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LnJlbW92ZSgnb3ZlcmZsb3cteS1oaWRkZW4nKVxuXG4gICAgICAgICAgICAgICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgICAgICAgICAgICAgIHRoaXMuYWN0aXZlQ29tcG9uZW50ID0gZmFsc2VcbiAgICAgICAgICAgICAgICAgICAgdGhpcy4kd2lyZS5yZXNldFN0YXRlKClcbiAgICAgICAgICAgICAgICB9LCAzMDApXG4gICAgICAgICAgICB9XG4gICAgICAgIH0sXG4gICAgICAgIGluaXQoKSB7XG4gICAgICAgICAgICB0aGlzLmluaXRpYWxpemVDb21wb25lbnQoKVxuXG4gICAgICAgICAgICB0aGlzLmxpc3RlbmVycy5wdXNoKFxuICAgICAgICAgICAgICAgIExpdmV3aXJlLm9uKCdjbG9zZVNjcmliYmxlTW9kYWwnLCAoZGF0YSkgPT4ge1xuICAgICAgICAgICAgICAgICAgICB0aGlzLmNsb3NlU2NyaWJibGVNb2RhbChkYXRhPy5mb3JjZSA/PyBmYWxzZSwgZGF0YT8uc2tpcFByZXZpb3VzTW9kYWxzID8/IDAsIGRhdGE/LmRlc3Ryb3lTa2lwcGVkID8/IGZhbHNlKVxuICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICApO1xuXG4gICAgICAgICAgICB0aGlzLmxpc3RlbmVycy5wdXNoKFxuICAgICAgICAgICAgICAgIExpdmV3aXJlLm9uKCdhY3RpdmVTY3JpYmJsZU1vZGFsQ29tcG9uZW50Q2hhbmdlZCcsICh7aWR9KSA9PiB7XG4gICAgICAgICAgICAgICAgICAgIHRoaXMuc2V0QWN0aXZlTW9kYWxDb21wb25lbnQoaWQpXG4gICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICk7XG4gICAgICAgIH0sXG4gICAgICAgIGRlc3Ryb3koKSB7XG4gICAgICAgICAgICB0aGlzLmxpc3RlbmVycy5mb3JFYWNoKChsaXN0ZW5lcikgPT4ge1xuICAgICAgICAgICAgICAgIGxpc3RlbmVyKClcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9LFxuICAgIH07XG59XG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQUEsT0FBTyxnQkFBZ0IsTUFBTTtBQUN6QixTQUFPO0FBQUEsSUFDSCxNQUFNO0FBQUEsSUFDTixxQkFBcUI7QUFBQSxJQUNyQixpQkFBaUI7QUFBQSxJQUNqQixrQkFBa0IsQ0FBQztBQUFBLElBQ25CLFlBQVk7QUFBQSxJQUNaLGdCQUFnQjtBQUFBLElBQ2hCLGFBQWE7QUFBQSxJQUNiLGdCQUFnQjtBQUFBLElBQ2hCLFdBQVcsQ0FBQztBQUFBLElBQ1osaUNBQWlDLEtBQUs7QUFDbEMsVUFBSSxLQUFLLE1BQU0sSUFBSSxZQUFZLEVBQUUsS0FBSyxlQUFlLE1BQU0sUUFBVztBQUNsRSxlQUFPLEtBQUssTUFBTSxJQUFJLFlBQVksRUFBRSxLQUFLLGVBQWUsRUFBRSxpQkFBaUIsRUFBRSxHQUFHO0FBQUEsTUFDcEY7QUFBQSxJQUNKO0FBQUEsSUFDQSxxQkFBcUI7QUFDakIsVUFBSSxLQUFLLGlDQUFpQyxlQUFlLE1BQU0sT0FBTztBQUNsRTtBQUFBLE1BQ0o7QUFFQSxVQUFJLFFBQVEsS0FBSyxpQ0FBaUMseUJBQXlCLE1BQU07QUFDakYsV0FBSyxtQkFBbUIsS0FBSztBQUFBLElBQ2pDO0FBQUEsSUFDQSx3QkFBd0I7QUFDcEIsVUFBSSxLQUFLLGlDQUFpQyxrQkFBa0IsTUFBTSxPQUFPO0FBQ3JFO0FBQUEsTUFDSjtBQUVBLFdBQUssbUJBQW1CLElBQUk7QUFBQSxJQUNoQztBQUFBLElBQ0EsbUJBQW1CLFFBQVEsT0FBTyxxQkFBcUIsR0FBRyxpQkFBaUIsT0FBTztBQUM5RSxVQUFHLEtBQUssU0FBUyxPQUFPO0FBQ3BCO0FBQUEsTUFDSjtBQUVBLFVBQUksS0FBSyxpQ0FBaUMsb0JBQW9CLE1BQU0sTUFBTTtBQUN0RSxjQUFNLGdCQUFnQixLQUFLLE1BQU0sSUFBSSxZQUFZLEVBQUUsS0FBSyxlQUFlLEVBQUU7QUFDekUsaUJBQVMsU0FB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
