export default (obj1, obj2) => {
  let globalSettingsString = JSON.stringify(obj1);
  let localSettingsString = JSON.stringify(obj2);
  return globalSettingsString === localSettingsString;
};
