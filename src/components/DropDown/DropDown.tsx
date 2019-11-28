import * as React from "react";

interface IAppProps {
  onChange(val: string): void;
  onSelect?:void
  value?: string;
  option?: [];
  Options: string[];
  defaultText:string
  
}

const DropDown: React.FC<IAppProps> = props => {
  const { Options, value, onChange,defaultText } = props;

  const [selected, setSelected] = React.useState(null);
  const [opened, setOpened] = React.useState(false);

  React.useEffect(() => {
    setSelected(value);
  }, [value]);

  const onOpen = () => {
    setOpened(!opened);
  };

  const onSelect = (option:string) => {
    setOpened(false);
    setSelected(option);
    onChange(option);
  };

  return (
    <div className="select-dd" onClick={onOpen}>
      <span>{selected ? selected : defaultText}</span>
      {Options?
      <ul className={opened ? "show" : "hide"}>
        <Option key={4444} option={defaultText} onSelect={onSelect} />
        {Options.map((o:string, i:number) => (
          <Option key={i} option={o} onSelect={onSelect} />
        ))}
      </ul>:null}
    </div>
  );
};
const Option = (props:any) => {
  const { onSelect, option } = props;

  const handleSelect = (e:React.MouseEvent) => {
    e.preventDefault();
    onSelect(option);
  };

  return (
    <li>
      <a href="#" onClick={handleSelect}>
        {option}
      </a>
    </li>
  );
};

export default DropDown;
