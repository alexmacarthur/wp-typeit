import { DEFAULT_OPTIONS as typeItDefaults } from "typeit/src/constants";
import { TextControl } from "@wordpress/components";
const { useRef, useState, useEffect } = wp.element;

export default () => {
  let activeBlock = useRef(wp.data.select("wp-typeit/store").getActiveBlock());
  let formRef = useRef(null);
  const [focusedInput, setFocusedInput] = useState(null);

  useEffect(() => {
    if (!formRef.current) return;
    if (!focusedInput) return;

    let i = formRef.current.querySelector(
      `[name="ti_setting[${focusedInput}]"]`
    );

    if (!i) return;

    i.focus();
  });

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
      let isBoolean = parseInt(value, 10).toString() === "NaN";

      value = isBoolean ? value : parseInt(value);

      updatedSettings[name] = value;
    });

    wp.data.dispatch("wp-typeit/store").updateSettings({
      clientId: activeBlock.current.clientId,
      settings: updatedSettings,
    });

    setSettings({ ...settings, ...updatedSettings });
  };

  let elements = Object.entries(settings).map(([setting, settingValue]) => {
    // Accounts for the "cursor" option, which is now an object by default.
    settingValue =
      typeof settingValue === "object" && settingValue !== null
        ? true
        : settingValue;

    let type = typeof settingValue;

    let TiCheckboxControl = () => {
      return (
        <label className="ti-GlobalSettings-checkboxControl">
          <input
            name={`ti_setting[${setting}]`}
            data-setting-name={""}
            type="checkbox"
            defaultChecked={settingValue}
            onChange={updateGlobalSettings}
            onFocus={() => setFocusedInput("")}
          />
          <span style={{ paddingRight: "10px" }}>{setting}</span>
        </label>
      );
    };

    let TiTextControl = () => {
      return (
        <TextControl
          name={`ti_setting[${setting}]`}
          label={setting}
          defaultValue={settingValue}
          onFocus={() => setFocusedInput(setting)}
          onBlur={() => setFocusedInput("")}
          onChange={updateGlobalSettings}
        />
      );
    };

    let el = type === "boolean" ? <TiCheckboxControl /> : <TiTextControl />;

    return (
      <span key={setting} style={{ display: "block", marginBottom: "1rem" }}>
        {el}
      </span>
    );
  });

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
