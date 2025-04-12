document.addEventListener('nextRecord', (event) => {
  const { recordId, url } = event.detail[0];

  // Check for unsaved changes before navigation
  if (hasUnsavedChanges()) {
    if (!confirm('You have unsaved changes. Are you sure you want to leave this page?')) {
      return;
    }
  }

  // Update browser history without page refresh
  window.history.pushState({ recordId }, '', url);
});

document.addEventListener('previousRecord', (event) => {
  const { recordId, url } = event.detail[0];

  // Check for unsaved changes before navigation
  if (hasUnsavedChanges()) {
    if (!confirm('You have unsaved changes. Are you sure you want to leave this page?')) {
      return;
    }
  }

  // Update browser history without page refresh
  window.history.pushState({ recordId }, '', url);
});

function hasUnsavedChanges() {
  // Check if there are any mounted actions or forms
  const livewireComponent = window.Livewire?.find(document.querySelector('[wire\\:id]')?.getAttribute('wire:id'));

  if (!livewireComponent) {
    return false;
  }

  const hasMountedActions = [
    ...(Array.isArray(livewireComponent.mountedActions) ? livewireComponent.mountedActions : []),
    ...(Array.isArray(livewireComponent.mountedFormComponentActions) ? livewireComponent.mountedFormComponentActions : []),
    ...(Array.isArray(livewireComponent.mountedInfolistActions) ? livewireComponent.mountedInfolistActions : []),
    ...(Array.isArray(livewireComponent.mountedTableActions) ? livewireComponent.mountedTableActions : []),
    ...(livewireComponent.mountedTableBulkAction ? [livewireComponent.mountedTableBulkAction] : []),
  ].length > 0;

  return hasMountedActions && !livewireComponent.__instance?.effects?.redirect;
}