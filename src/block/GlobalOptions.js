import { DEFAULT_OPTIONS as typeItDefaults } from "typeit/src/contants";
import { TextControl } from "@wordpress/components";
const { useRef, useState } = wp.element;

export default () => {
  let activeBlock = useRef(wp.data.select("wp-typeit/store").getActiveBlock());
  let formRef = useRef(null);

  const [settings, setSettings] = useState(() => {
    let settings = {
      ...typeItDefaults,
      ...wp.data.select("wp-typeit/store").getSettings()[
        activeBlock.current.clientId
      ],
    };

    delete settings.strings;
    delete settings.beforeString;
    delete settings.afterString;
    delete settings.beforeStep;
    delete settings.afterStep;
    delete settings.afterComplete;
    return settings;
  }, []);

  const updateGlobalSettings = () => {
    let settingsInputs = [...formRef.current.elements].filter((i) =>
      i.name.startsWith("ti_setting")
    );
    let updatedSettings = {};

    settingsInputs.forEach((s) => {
      let name = s.name.match(/ti_setting\[(.+?)\]/)[1];
      let value = s.type === "checkbox" ? s.checked : s.value;

      value =
        parseInt(value, 10).toString() === "NaN" ? value : parseInt(value);

      updatedSettings[name] = value;
    });

    wp.data.dispatch("wp-typeit/store").updateSettings({
      clientId: activeBlock.current.clientId,
      settings: updatedSettings,
    });

    setSettings({ ...settings, ...updatedSettings });
  };

  let elements = [];

  for (const setting in settings) {
    let type = typeof settings[setting];
    let settingValue = settings[setting];

    let TiCheckboxControl = () => {
      return (
        <label className="ti-GlobalSettings-checkboxControl">
          <input
            name={`ti_setting[${setting}]`}
            data-setting-name={""}
            type="checkbox"
            defaultChecked={settingValue}
          />
          <span style={{ paddingRight: "10px" }}>{setting}</span>
        </label>
      );
    };

    let TiTextControl = () => {
      return (
        <TextControl
          name={`ti_setting[${setting}]`}
          onBlur={updateGlobalSettings}
          label={setting}
          defaultValue={settingValue}
          onChange={() => {}}
        />
      );
    };

    let el = type === "boolean" ? <TiCheckboxControl /> : <TiTextControl />;

    elements.push(
      <span style={{ display: "block", marginBottom: "1rem" }}>{el}</span>
    );
  }

  return (
    <div className="ti-GlobalSettings">
      <span className="ti-HelperText">
        For more information on what each of these options mean,{" "}
        <a
          rel="noopener noreferrer"
          target="_blank"
          href="https://typeitjs.com/docs#options"
        >
          see here.
        </a>
      </span>

      <form ref={formRef} onBlur={updateGlobalSettings}>
        {elements}
      </form>
    </div>
  );
};
