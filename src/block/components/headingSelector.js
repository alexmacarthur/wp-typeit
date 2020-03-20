export default ({ updateHeading, defaultHeading }) => {
  const elements = ["span", "h1", "h2", "h3", "h4", "h5", "h6"];

  return (
    <select onChange={(e) => updateHeading(e.target.value)}>
      {elements.map((element) => {
        return (
          <option
            key={element}
            value={element}
            selected={element === defaultHeading}
          >
            {element}
          </option>
        );
      })}
    </select>
  );
};
