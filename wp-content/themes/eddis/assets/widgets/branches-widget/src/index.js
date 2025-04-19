const { createElement, render } = wp.element;
import './styles/branches-widget.scss'; // Importa el archivo SCSS
import BranchesWidget from './components/BranchesWidget';

document.addEventListener('DOMContentLoaded', () => {
  const rootElement = document.getElementById('branches-widget-root');
  if (rootElement) {
    render(
      createElement(BranchesWidget, { data: window.branchesData || {} }),
      rootElement
    );
  }
});
