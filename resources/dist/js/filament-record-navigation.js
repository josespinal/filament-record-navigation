// When the user navigates to the first record, 
// we need to set the browser history
document.addEventListener('start-record-navigation', (event) => {
  const { recordId, url } = event.detail[0];
  window.history.replaceState({ recordId }, '', url);
});

// When the user navigates back or forward in the browser, 
// we need to update the record
window.addEventListener("popstate", (event) => {
  if (event.state) {
    Livewire.dispatch('execute-change-record', { 'recordId': event.state.recordId });
  }
});

// When the user navigates to a new record with the filament navigation, 
// we need to update the browser history
document.addEventListener('changeNavigationRecord', (event) => {
  const { recordId, url, isViewRecord, componentId, confirmMessage } = event.detail[0];

  const component = Livewire.find(componentId);

  console.log(component.data, isViewRecord);

  if (!isViewRecord) {
    if (
      window.jsMd5(
        JSON.stringify(component.data).replace(/\\/g, ''),
      ) !== component.savedDataHash ||
      component?.__instance?.effects?.redirect
    ) {
      if (confirm(confirmMessage)) {
        window.history.pushState({ recordId }, '', url);
        component.executeChangeRecord(recordId);
      }
      return;
    }
  }


  window.history.pushState({ recordId }, '', url);
  component.executeChangeRecord(recordId);
});