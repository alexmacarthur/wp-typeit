const { registerStore } = wp.data;
import { DEFAULT_OPTIONS as settings } from "typeit/src/contants";

const initialState = {
  settings,
  activeBlock: {},
};

const reducer = (state = initialState, action) => {
  switch (action.type) {
    case "UPDATE_SETTINGS": {
      let { clientId, settings } = action.value;
      let preexistingSettings = state.settings[clientId]
        ? state.settings[clientId]
        : {};

      return {
        ...state,
        settings: {
          [clientId]: { ...preexistingSettings, ...settings },
        },
      };
    }

    case "SET_ACTIVE_BLOCK": {
      return {
        ...state,
        activeBlock: action.value,
      };
    }
  }

  return state;
};

const actions = {
  updateSettings(value) {
    return {
      type: "UPDATE_SETTINGS",
      value,
    };
  },

  setActiveBlock(clientId) {
    return {
      type: "SET_ACTIVE_BLOCK",
      value: clientId,
    };
  },
};

const selectors = {
  getSettings(state) {
    return state.settings;
  },

  getActiveBlock(state) {
    return state.activeBlock || {};
  },
};

registerStore("wp-typeit/store", {
  reducer,
  actions,
  selectors,
});
