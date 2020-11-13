import { PanelBody } from "@wordpress/components";
import GlobalOptions from "./GlobalOptions";

const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { InspectorControls } = wp.editor;

wp.hooks.addFilter(
  "editor.BlockEdit",
  "wp-typeit/with-inspector-controls",
  createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      const activeBlock = wp.data.select("wp-typeit/store").getActiveBlock();
      const activeBlockName = activeBlock ? activeBlock.name : "";

      return (
        <Fragment>
          <BlockEdit {...props} />
          <InspectorControls>
            {activeBlockName === "wp-typeit/block" && (
              <PanelBody title="TypeIt Settings">
                <GlobalOptions />
              </PanelBody>
            )}
          </InspectorControls>
        </Fragment>
      );
    };
  }, "withInspectorControl")
);
