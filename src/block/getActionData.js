const actions = [
  {
    name: "type",
    type: "text",
    placeholder: "characters to type",
    default: true,
  },
  {
    name: "delete",
    type: "text",
    placeholder: "number of characters, or a CSS selector",
  },
  {
    name: "move",
    type: "text",
    placeholder: "number of characters, or a CSS selector",
  },
  {
    name: "break",
    type: null,
    placeholder: "accepts no arguments",
  },
  {
    name: "pause",
    type: "number",
    placeholder: "number of milliseconds to pause",
  },
  {
    name: "empty",
    type: null,
    placeholder: "accepts no arguments",
  },
];

export default (name) => {
  return actions.find((a) => a.name === name);
};

export const getAllActions = () => {
  return actions;
};

export const getDefaultActionData = () => {
  return actions.find((a) => a.default);
};
