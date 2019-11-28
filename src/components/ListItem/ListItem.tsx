import * as React from "react";
import * as models from "../../models"
 
interface Iprops{
  data:models.ICharacter
  click?:any
}


const ListItem = (props:Iprops) => {
  const { data, click } = props;
  const HandleClick = (e:React.MouseEvent) => {
    e.preventDefault;
    click(data);
  };

  return (
    <li onClick={HandleClick} className={"m-2"}>
      <div className="d-flex fd-col fa-center card">
        <div>
          <h1>{data.name}</h1>
        </div>
        <img src={data.image} alt="" />
        <h3>Gender: {data.gender}</h3>
        <h3>Status: {data.status}</h3>
        <h3>Species: {data.species}</h3>
      </div>
    </li>
  );
};

export default ListItem;
