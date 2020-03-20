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
      return (
        <Fragment>
          <BlockEdit {...props} />
          <InspectorControls>
            <PanelBody title="TypeIt Settings">
              <GlobalOptions />
            </PanelBody>
          </InspectorControls>
        </Fragment>
      );
    };
  }, "withInspectorControl")
);
