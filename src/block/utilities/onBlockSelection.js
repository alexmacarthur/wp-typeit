const { subscribe } = wp.data;

/**
 * Fires whenever a block is selected in the editor.
 *
 * @param {function} callback
 */
const onBlockSelection = (callback) => {
  subscribe(() => {
    const selectedBlock = wp.data
      .select("core/block-editor")
      .getSelectedBlock();
    const currentActiveBlock = wp.data
      .select("wp-typeit/store")
      .getActiveBlock();
    const currentActiveClientId = currentActiveBlock
      ? currentActiveBlock.clientId
      : null;

    if (!selectedBlock) {
      return;
    }

    if (selectedBlock.clientId === currentActiveClientId) {
      return;
    }

    callback(selectedBlock);
  });
};

export default onBlockSelection;
