import * as React from "react";
import * as actions from "../../redux/actions";
import { connect } from "react-redux";
import ListItem from "../ListItem/ListItem";
import Modal from "../Modal/Modal";
import Details from "../Details/Details";
import PagerButton from "../PagerButton/PagerButton";
import { PropsWithChildren } from "react";
import * as models from "../../models";
import DropDown from "../DropDown/DropDown";

const nothing = "/src/assets/nothing.png";

const status = ["alive", "dead", "unknown"];
const gender = ["female", "male", "genderless", "unknown"];

interface Iprops {
  fetchCharacters: any;
  characters: any;
  species: any;
  info: any;
  loading: any;
  location: any;
  history: any;
  errorInSearch: boolean;
}

const defaultValues: any = {
  species: null,
  status: null,
  gender: null
};

const List: React.FC = (props: PropsWithChildren<Iprops>) => {
  const {
    fetchCharacters,
    characters,
    species,
    info,
    loading,
    location,
    history,
    errorInSearch
  } = props;

  const [drodownValues, setDefaultValues] = React.useState(defaultValues);
  const [modalOpen, setModal] = React.useState(false);
  const [selectedCharacter, setCharacter] = React.useState(null);

  React.useEffect(() => {
    fetchCharacters(location ? location.search : "");
    getDefaultValue();
  }, [location]);

  const getDefaultValue = () => {
    let params = new URLSearchParams(document.location.search.substring(1));
    setDefaultValues({
      species: params.get("species"),
      status: params.get("status"),
      gender: params.get("gender")
    });
  };

  const HandleModal = (data: models.ICharacter[]) => {
    setModal(!modalOpen);
    setCharacter(data);
  };

  const handleLocationChangeChange = (el: string, val: any) => {
    let params = new URLSearchParams(document.location.search.substring(1));
    if (
      !val ||
      val == "Select Species" ||
      val == "Select Status" ||
      val == "Select Gender"
    ) {
      params.delete(el);
    } else {
      params.set(el, val);
    }
    history.push({
      pathname: location.pathname,
      search: params.toString()
    });
  };

  const GoBack: React.FC = () => {
    return (
      <div className={"nothing-here d-flex fd-col fa-center p404"}>
        <img src={nothing} />
        <h1>There is nothing Here !</h1>
        <button className="btn" onClick={() => history.goBack()}>
          Go Back!
        </button>
      </div>
    );
  };

  return (
    <div>
      <div className={"d-flex"}></div>

      <h1 className="title">Rick and Morty</h1>
      {loading && errorInSearch ? (
        <GoBack />
      ) : (
        <div className={"list-container d-flex fd-col fa-center"}>
          <div className={"d-flex controls "}>
            <PagerButton
              handleNavigate={handleLocationChangeChange}
              text={"Prev"}
              querySting={history}
              link={info.prev}
            />
            <DropDown
              Options={species}
              onChange={val => handleLocationChangeChange("species", val)}
              value={drodownValues.species ? drodownValues.species : null}
              defaultText={"Select Species"}
            />
            <DropDown
              Options={status}
              onChange={val => handleLocationChangeChange("status", val)}
              value={drodownValues.status ? drodownValues.status : null}
              defaultText={"Select Status"}
            />
            <DropDown
              Options={gender}
              onChange={val => handleLocationChangeChange("gender", val)}
              value={drodownValues.gender ? drodownValues.gender : null}
              defaultText={"Select Gender"}
            />

            <PagerButton
              handleNavigate={handleLocationChangeChange}
              text={"Next"}
              querySting={history}
              link={info.next}
            />
          </div>
          <div>
            <ul className={"d-flex fa-center m-auto list"}>
              {characters.map((character: models.ICharacter) => {
                return (
                  <ListItem
                    click={HandleModal}
                    key={character.id}
                    data={character}
                  />
                );
              })}
            </ul>
          </div>
        </div>
      )}
      <Modal displayModal={modalOpen} closeModal={HandleModal}>
        <Details character={selectedCharacter} />
      </Modal>
    </div>
  );
};

const mapStateToProps = (state: models.IData) => {
  return {
    characters: state.data.characters,
    info: state.data.info,
    loading: state.data.loading,
    species: state.data.species,
    errorInSearch: state.data.errorInSearch
  };
};

const mapDispatchToStore = (dispatch: any) => {
  return {
    fetchCharacters: (query: string) => dispatch(actions.fetchCharacters(query))
  };
};

export default connect(mapStateToProps, mapDispatchToStore)(List);
