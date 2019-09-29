import React, { Component } from "react";
import FilterGender from "./components/FilterGender";
import FilterSpecies from "./components/FilterSpecies";
import FilterStatus from "./components/FilterStatus";
import Pagination from "./views/Pagination";
import ErrorMessage from "./views/ErrorMessage";
import CharactersList from "./views/CharactersList";
import apiEndpointBuilder from "./utils/apiEndpointBuilder";
import paging from "./utils/paging";

import classes from "./sass/App.module.scss";

import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import CardDeck from "react-bootstrap/CardGroup";
import InfoModal from "./views/InfoModal";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import Image from "react-bootstrap/Image";
import logo from "./assets/img/logo.png";

class App extends Component {
  constructor(props) {
    super(props);

    this.state = {
      info: {},
      characters: [],
      selectedCharacter: {},
      paging: {
        currentPage: 1
      },
      error: "",
      show: false,
      hide: false,
      urlParams: "",
      homeUrl: window.location.origin,
    };
  }
  getCharacters = () => {
    const endpoint = "https://rickandmortyapi.com/api/character/";
    const apiEndpoint = window.location.search
      ? `${endpoint}${window.location.search}`
      : endpoint;
    fetch(apiEndpoint)
      .then(results => {
        if (results.ok) {
          return results.json();
        }
        this.setState({ error: "Something went worng. Please try again" });
      })
      .then(data => {
        this.setState({
          info: data.info,
          characters: data.results
        });
      })
      .catch(error => {
        this.setState({ error: "Something went worng. Please try again" });
      });
  };
  componentDidMount() {
    const endpoint = "https://rickandmortyapi.com/api/character/";
    const apiEndpoint = window.location.search
      ? `${endpoint}${window.location.search}`
      : endpoint;
    fetch(apiEndpoint)
      .then(results => {
        if (results.ok) {
          return results.json();
        }
        this.setState({ error: "Something went worng. Please try again" });
      })
      .then(data => {
        this.setState({
          info: data.info,
          characters: data.results
        });
      })
      .catch(error => {
        this.setState({ error: "Something went worng. Please try again" });
      });
  }

  nextPage = () => {
    const newApiEndpoint = paging(true, this.state.paging.currentPage);

    fetch(newApiEndpoint)
      .then(results => {
        if (results.ok) {
          return results.json();
        }
        this.setState({ error: "Something went worng. Please try again" });
      })
      .then(data => {
        this.setState({
          info: data.info,
          characters: data.results,
          paging: {
            currentPage: this.state.paging.currentPage + 1
          }
        });
      })
      .catch(error => {
        this.setState({ error: "Something went worng. Please try again" });
      });
  };

  prevPage = () => {
    const newApiEndpoint = paging(false, this.state.paging.currentPage);
    fetch(newApiEndpoint)
      .then(results => {
        if (results.ok) {
          return results.json();
        }
        this.setState({ error: "Something went worng. Please try again" });
      })
      .then(data => {
        this.setState({
          info: data.info,
          characters: data.results,
          paging: {
            currentPage: this.state.paging.currentPage - 1
          }
        });
      })
      .catch(() => {
        this.setState({ error: "Something went worng. Please try again" });
      });
  };

  handleFilter = (e, filterBy) => {
    const apiEndpoint = apiEndpointBuilder(filterBy, e.target.dataset.value);

    fetch(apiEndpoint)
      .then(results => {
        if (results.ok) {
          return results.json();
        }
        this.setState({ error: "Something went worng. Please try again" });
      })
      .then(data => {
        this.setState({
          info: data.info,
          characters: data.results
        });
      })
      .catch(() => {
        this.setState({ error: "Something went worng. Please try again" });
      });
  };

  handleShow = () => {
    this.setState({ show: !this.state.show });
  };

  setSelectedCharacter = c => {
    console.log(c);
    this.setState({
      selectedCharacter: {
        ...c,
        location: c.location.name,
        origin: c.origin.name
      },
      show: !this.state.show
    });
  };

  render() {
    return (
      <div>
        <Navbar sticky="top" bg="dark" variant="dark" expand="lg">
          <Navbar.Brand href={this.state.homeUrl}>
            <Image src={logo} className={classes.Logo} fluid />
          </Navbar.Brand>
          <Navbar.Toggle aria-controls="basic-navbar-nav" />
          <Navbar.Collapse id="basic-navbar-nav">
            <Nav className="mr-auto">
              <Nav.Link href={this.state.homeUrl}>Home</Nav.Link>
              <FilterGender clicked={e => this.handleFilter(e, "gender")} />
              <FilterSpecies clicked={e => this.handleFilter(e, "species")} />
              <FilterStatus clicked={e => this.handleFilter(e, "status")} />
            </Nav>
          </Navbar.Collapse>
        </Navbar>
        <div className={classes.centeredContent}>
          {this.state.error ? (
            <ErrorMessage
              homeUrl={this.state.homeUrl}
              error={this.state.error}
            />
          ) : (
            <div>
              <Pagination
                currentPage={this.state.paging.currentPage}
                pages={this.state.info.pages}
                nextPage={this.nextPage}
                prevPage={this.prevPage}
              />

              <InfoModal
                show={this.state.show}
                onHide={() => this.handleShow()}
                character={this.state.selectedCharacter}
              />
              <CharactersList
                characters={this.state.characters}
                setSelectedCharacter={this.setSelectedCharacter}
              />
            </div>
          )}
        </div>
      </div>
    );
  }
}

export default App;
