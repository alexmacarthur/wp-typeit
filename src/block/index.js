import "./store";
import "./registerSettingsPanel";
import { arrayMoveImmutable as arrayMove } from "array-move";
import { DEFAULT_OPTIONS as typeItDefaults } from "typeit/src/contants";
import ActionInput from "./components/actionInput";
import HeadingSelector from "./components/headingSelector";
import ActionList from "./components/actionList";
import actionsToString from "./utilities/actionsToString";
import objectsAreEqual from "./utilities/objectsAreEqual";
import onBlockSelection from "./utilities/onBlockSelection";
import generateHash from "./utilities/generateHash";

const { registerBlockType } = wp.blocks;
const { useEffect, useRef } = wp.element;
const { subscribe } = wp.data;

// Whenever global data changes, check if we should update
// the active block set in the TypeIt global store.
onBlockSelection((selectedBlock) => {
  wp.data.dispatch("wp-typeit/store").setActiveBlock(selectedBlock);
});

registerBlockType("wp-typeit/block", {
  title: "TypeIt",
  icon: "editor-paste-text",
  category: "common",
  attributes: {
    actions: {
      type: "array",
      default: [],
    },
    settings: {
      type: "object",
      default: {},
    },
    instanceId: {
      type: "string",
      default: "",
    },
    heading: {
      type: "string",
      default: "span",
    },
  },
  edit: ({ className, attributes, setAttributes, clientId }) => {
    const containerRef = useRef(null);
    const getGlobalSettings = () => {
      return wp.data.select("wp-typeit/store").getSettings()[clientId];
    };

    const updateGlobalSettings = () => {
      const settingsAreEmpty = JSON.stringify(attributes.settings) === "{}";

      wp.data.dispatch("wp-typeit/store").updateSettings({
        clientId,
        settings: settingsAreEmpty ? typeItDefaults : attributes.settings,
      });
    };

    // Load saved settings into store.
    // Will happen ONCE as the block is registered, not for each `edit` focus.
    useEffect(() => {
      setAttributes({ instanceId: generateHash() });
      updateGlobalSettings();
    }, []);

    useEffect(() => {
      const unsubscribe = subscribe(() => {
        let globalSettings = getGlobalSettings();
        if (!objectsAreEqual(globalSettings, attributes.settings)) {
          unsubscribe();
          setAttributes({ settings: globalSettings });
        }
      });

      return () => {
        unsubscribe();
      };
    });

    const getArgumentType = (value) => {
      return parseInt(value, 10).toString() === "NaN" ? "string" : "number";
    };

    const addAction = (name, value) => {
      let actions = [
        ...attributes.actions,
        { name, value, type: getArgumentType(value) },
      ];
      setAttributes({ actions });
    };

    const deleteAction = (indexToRemove) => {
      let actions = attributes.actions.concat();
      actions.splice(indexToRemove, 1);
      setAttributes({ actions });
    };

    const updateAction = ({ index, name, value } = {}) => {
      let actions = [...attributes.actions];
      actions[index] = { name, value, type: getArgumentType(value) };
      setAttributes({ actions });
    };

    const updateHeading = (heading) => {
      setAttributes({ heading });
    };

    const onSortEnd = ({ oldIndex, newIndex }) => {
      let actions = arrayMove(attributes.actions, oldIndex, newIndex);
      setAttributes({ actions });
    };

    return (
      <div className={`${className} ti-Block`} ref={containerRef}>
        <h5 className="ti-Heading">TypeIt Animation</h5>

        <div className="ti-SectionWrapper">
          <h6 className="ti-Heading">Choose a Heading</h6>

          <div className="ti-Row">
            <div className="ti-Row-cell">
              <HeadingSelector
                updateHeading={updateHeading}
                defaultHeading={attributes.heading}
              />
            </div>

            <div className="ti-Row-cell">
              <span className="ti-HelperText ti-HelperText--noMargin">
                The element that will contain the animation.
              </span>
            </div>
          </div>
        </div>

        <div className="ti-SectionWrapper">
          <h6 className="ti-Heading">Add Actions to Queue</h6>
          <span className="ti-HelperText">
            The individual actions to be executed (typing, pausing, deleting,
            etc.). For full documentation on these actions, read {""}{" "}
            <a
              target="_blank"
              rel="noreferrer noopener"
              href="https://typeitjs.com/docs"
            >
              the full documentation.
            </a>
          </span>

          <ActionInput addAction={addAction} />
        </div>

        <div className="ti-SectionWrapper">
          <h6 className="ti-Heading">Queued Actions</h6>

          <ActionList
            actions={attributes.actions}
            containerRef={containerRef}
            updateAction={updateAction}
            onSortEnd={onSortEnd}
            deleteAction={deleteAction}
          />
        </div>
      </div>
    );
  },
  save: ({ attributes }) => {
    let { settings = {}, instanceId, actions } = attributes;
    let id = `typeIt_${instanceId}`;
    let actionChain = actionsToString(actions);

    return (
      <>
        <attributes.heading id={id} />

        <script
          dangerouslySetInnerHTML={{
            __html: `
            window.addEventListener('load', function () {
              window.${id} = new TypeIt(
                "#${id}", 
                ${JSON.stringify(settings)}
              )${actionChain}.go();
            });
          `,
          }}
        ></script>
      </>
    );
  },
});
