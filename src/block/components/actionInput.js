import { Button } from "@wordpress/components";
import ActionSelector from "./actionSelector";
import getActionData, { getDefaultActionData } from "../getActionData";
const { useRef, useState } = wp.element;

export default ({
  editOnly = false,
  initialActionName = "",
  initialArgumentValue = "",
  addAction = () => {},
  onSelect = () => {},
  onArgumentBlur = () => {},
}) => {
  const actionArgRef = useRef(null);
  const initialAction = initialActionName
    ? getActionData(initialActionName)
    : getDefaultActionData();

  const [actionData, setActionData] = useState(initialAction);

  const queueNewAction = () => {
    addAction(actionData.name, actionArgRef.current.value);

    // Reset everything!
    setActionData(initialAction);
    actionArgRef.current.value = "";
  };

  return (
    <form className="ti-ActionInput">
      <div className="ti-ActionInput-container">
        <div className="ti-ActionInput-selector">
          <ActionSelector
            initialActionName={actionData.name}
            onSelect={(actionName) => {
              setActionData(getActionData(actionName));
              onSelect(actionName);
            }}
          />
        </div>

        <div className="ti-ActionInput-argument">
          <input
            disabled={!actionData.type}
            type={actionData.type || "text"}
            ref={actionArgRef}
            defaultValue={initialArgumentValue}
            placeholder={actionData.placeholder}
            onBlur={(e) => {
              onArgumentBlur(e.target.value);
            }}
          />
        </div>

        {!editOnly && (
          <Button onClick={queueNewAction} isPrimary>
            Add
          </Button>
        )}
      </div>
    </form>
  );
};
