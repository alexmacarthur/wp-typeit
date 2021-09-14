export default (actions) => {
  return actions.reduce((total, item) => {
    let value = item.type === "string" ? `"${item.value}"` : item.value;

    return `${total}.${item.name}(${value})`;
  }, "");
};
