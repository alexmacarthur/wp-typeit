export default () => {
  let selectedBlock = wp.data.select("core/block-editor").getSelectedBlock();
  let activeClientId = wp.data.select("wp-typeit/store").getActiveBlock();

  if (!selectedBlock) {
    return;
  }

  if (selectedBlock.clientId === activeClientId) {
    return;
  }

  wp.data.dispatch("wp-typeit/store").setActiveBlock(selectedBlock.clientId);
};
