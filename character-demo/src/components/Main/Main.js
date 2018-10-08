import React from 'react';
import './Main.scss';
import CharacterCard from '../CharacterCard/CharacterCard';
import Footer from './Footer';
import Modal from '../Modal/Modal';
import { API_URL } from '../../config';

import Loader from 'react-loader-spinner';


var selectedChar;

class Main extends React.Component {

    constructor(props) {
        super(props);

        this.prevButtonPress = this.prevButtonPress.bind(this);
        this.nextButtonPress = this.nextButtonPress.bind(this);
        this.handleClick = this.handleClick.bind(this);
        this.onOverlayClick = this.onOverlayClick.bind(this);
        
        this.state = {
            pending: true,
            sortedArray: [],
            prev: null,
            next: null,
            filter: false,
            sortByGender: null,
            spieces: '',
            status: '',
            show: false
        }
    }

    
    componentWillMount = () => {

        this.getContent();
    }

    getContent() {
        fetch(API_URL, {
            method: 'GET',
            // body: requestData
        }).then((response) => response.json()).then((data) => {

            console.log(data);
            this.setState({
                characters: data.results,
                sortedArray: data.results,
                prev: data.info.prev,
                next: data.info.next
            });

        }).catch((err) => {

            console.log(err);

        }).finally(() => {
            this.setState({
                pending: false
            });
        });
    }

    sortContentGender(e) {
        var sortBy = e.target.value;
        // let charactersArray = this.state.characters;
        let sortedArray = this.state.characters;


        switch (sortBy) {
            case 'Male':
                sortedArray = Array.prototype.slice.call(this.state.characters).filter(x => {
                    return x.gender !== "Female" && x.gender !== "unknown";
                });
                break;
            case 'Female':
                sortedArray = Array.prototype.slice.call(this.state.characters).filter(x => {
                    return x.gender !== "Male" && x.gender !== "unknown";
                });
                break;
            default:
                break;
        }

        console.log(sortedArray);
        this.setState({ sortedArray: sortedArray, sortBy: e.target.value });
    }


    handleClick(character, e) {
        selectedChar = character;
        // console.log(selectedChar);      
            this.setState({
                show: true
            });
    }

    onOverlayClick() {
        this.hideModal();
      }


    hideModal = () => {
        this.setState({
            show: false
        });
    };
   

    nextButtonPress(e) {
        this.setState({ pending: true});
        e.preventDefault();
        fetch(this.state.next, {
            method: 'GET',
            // body: requestData
        }).then((response) => response.json()).then((data) => {

            console.log(data);
            this.setState({
                characters: data.results,
                sortedArray: data.results,
                prev: data.info.prev,
                next: data.info.next
            });

        }).catch((err) => {

            console.log(err);

        }).finally(() => {
            this.setState({
                pending: false
            });
        });
    }

    prevButtonPress(e) {
        this.setState({ pending: true});
        e.preventDefault();
        fetch(this.state.prev, {
            method: 'GET',
            // body: requestData
        }).then((response) => response.json()).then((data) => {

            console.log(data);
            this.setState({
                characters: data.results,
                sortedArray: data.results,
                prev: data.info.prev,
                next: data.info.next
            });

        }).catch((err) => {

            console.log(err);

        }).finally(() => {
            this.setState({
                pending: false
            });
        });
    }

    renderHeader() {
        return (
            <div className="headerContainer">
                <div className="genderContainer">
                    <div className="sortby">Sort by Gender:</div>
                    <div>
                        <select id="lang" onChange={e => this.sortContentGender(e)}>
                            <option value="None">None</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
                <div className="spiecesContainer">
                    <div className="sortby">Sort by Spieces:</div>
                    <div>
                        <select id="lang" onChange={e => this.sortContentSpieces(e)}>
                            <option value="none">None</option>
                            <option value="spieces">Spieces</option>
                        </select>
                    </div>
                </div>
                <div className="statusContainer">
                    <div className="sortby">Sort by Status:</div>
                    <div>
                        <select id="lang" onChange={e => this.sortContentStatus(e)}>
                            <option value="none">None</option>
                            <option value="status">Status</option>
                        </select>
                    </div>
                </div>
            </div>
        );
    }



    renderBody() {
        if (this.state.characters && !this.state.pending) {

            return (
                <div className="main">

                    {this.state.sortedArray.map((character, i) => (
                        <CharacterCard character={character} key={i} clickCard={this.handleClick.bind(this, character)}/> 
                     ))}
                     {this.state.sortedArray.map((character, j) => (
                         <Modal character={character} selectedCharacter={selectedChar} onOverlay={this.onOverlayClick} isShown ={this.state.show} key={j}/>
                         ))} 
                </div>
            );
        } else {
            return (
                <div className="loader">
                    <Loader
                        type="Triangle"
                        color="#f1f1f1"
                        height="250"
                        width="250"
                    />
                </div>
            );

        }
    }

    render() {
        let header = this.renderHeader();
        let body = this.renderBody();

        return (
            <div className="app">
                <div className="mainHeader">
                    {header}
                </div>
                <div >
                    {body}
                </div>
                <Footer footer={this.state} nextButtonPress={this.nextButtonPress} prevButtonPress={this.prevButtonPress} />

            </div>

        );

    }

}

export default Main;