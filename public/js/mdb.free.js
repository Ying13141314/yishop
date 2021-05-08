// BOOTSTRAP CORE COMPONENTS
import Alert from '../../../../../Users/linyi/Escritorio/src/js/bootstrap/src/alert';
import Button from '../../../../../Users/linyi/Escritorio/src/js/bootstrap/src/button';
import Carousel from '../../../../../Users/linyi/Escritorio/src/js/bootstrap/src/carousel';
import Collapse from '../../../../../Users/linyi/Escritorio/src/js/bootstrap/src/collapse';
import Modal from '../../../../../Users/linyi/Escritorio/src/js/bootstrap/src/modal';
import Popover from '../../../../../Users/linyi/Escritorio/src/js/bootstrap/src/popover';
import ScrollSpy from '../../../../../Users/linyi/Escritorio/src/js/bootstrap/src/scrollspy';
import Tab from '../../../../../Users/linyi/Escritorio/src/js/bootstrap/src/tab';
import Tooltip from '../../../../../Users/linyi/Escritorio/src/js/bootstrap/src/tooltip';
import Toast from '../../../../../Users/linyi/Escritorio/src/js/bootstrap/src/toast';

// MDB FREE COMPONENTS
import Input from '../../../../../Users/linyi/Escritorio/src/js/free/input';
import Dropdown from '../../../../../Users/linyi/Escritorio/src/js/free/dropdown';
import Ripple from '../../../../../Users/linyi/Escritorio/src/js/free/ripple';

// AUTO INIT
[...document.querySelectorAll('[data-toggle="tooltip"]')].map((tooltip) => new Tooltip(tooltip));
[...document.querySelectorAll('[data-toggle="popover"]')].map((popover) => new Popover(popover));
[...document.querySelectorAll('.toast')].map((toast) => new Toast(toast));

export {
  Alert,
  Button,
  Carousel,
  Collapse,
  Dropdown,
  Input,
  Modal,
  Popover,
  Ripple,
  ScrollSpy,
  Tab,
  Toast,
  Tooltip,
};
