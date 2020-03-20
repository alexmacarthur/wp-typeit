import { SortableContainer, SortableElement } from "react-sortable-hoc";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faArrowsAltV, faTimes } from "@fortawesome/free-solid-svg-icons";

import ActionInput from "./actionInput";

const { useMemo } = wp.element;

export default ({
  actions,
  onSortEnd,
  deleteAction,
  containerRef,
  updateAction,
}) => {
  const Item = useMemo(
    () =>
      SortableElement(({ action, actionIndex }) => {
        return (
          <li className="ti-ActionList-item ti-QueuedAction">
            <ul className="ti-QueuedAction-details">
              <li className="ti-QueuedAction-part ti-QueuedAction-dragger">
                <FontAwesomeIcon icon={faArrowsAltV} />
              </li>

              <li className="ti-QueuedAction-part ti-QueuedAction-mainPart">
                <ActionInput
                  initialActionName={action.name}
                  initialArgumentValue={action.value}
                  editOnly={true}
                  onSelect={(name) =>
                    updateAction({
                      index: actionIndex,
                      name,
                      value: action.value,
                    })
                  }
                  onArgumentBlur={(value) => {
                    if (value === action.value) {
                      return;
                    }

                    updateAction({
                      index: actionIndex,
                      name: action.name,
                      value,
                    });
                  }}
                />
              </li>

              <li className="ti-QueuedAction-part">
                <button onClick={() => deleteAction(actionIndex)}>
                  <FontAwesomeIcon icon={faTimes} />
                  Delete
                </button>
              </li>
            </ul>
          </li>
        );
      }),
    [actions]
  );

  const List = useMemo(
    () =>
      SortableContainer(({ acts }) => {
        return (
          <ul className="ti-ActionList">
            {acts.map((action, index) => {
              return (
                <Item
                  key={`item-${index}`}
                  action={action}
                  index={index}
                  actionIndex={index}
                />
              );
            })}
          </ul>
        );
      }),
    [actions]
  );

  return (
    <>
      {!!actions.length && (
        <List
          acts={actions}
          onSortEnd={onSortEnd}
          helperContainer={containerRef.current}
        />
      )}

      {!actions.length && <small>None yet!</small>}
    </>
  );
};
