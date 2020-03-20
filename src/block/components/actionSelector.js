import { getAllActions } from "../getActionData";

export default ({ onSelect, initialActionName = "type" }) => {
  const ucFirstLetter = (word) => {
    return word.charAt(0).toUpperCase() + word.slice(1);
  };

  return (
    <select onChange={(e) => onSelect(e.target.value)}>
      {getAllActions().map((action) => {
        return (
          <option
            key={action.name}
            value={action.name}
            selected={initialActionName === action.name}
          >
            {ucFirstLetter(action.name)}
          </option>
        );
      })}
    </select>
  );
};
