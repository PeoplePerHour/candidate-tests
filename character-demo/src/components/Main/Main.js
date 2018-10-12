import React from 'react';
import './Main.scss';
import CharacterCard from '../CharacterCard/CharacterCard';
import Footer from './Footer';
import Modal from '../Modal/Modal';
import { API_URL } from '../../config';
import queryString from 'query-string';
import { withRouter } from 'react-router-dom';
import Loader from 'react-loader-spinner';



var selectedChar, valuesURL;

class Main extends React.Component {

    constructor(props) {
        super(props);

        this.prevButtonPress = this.prevButtonPress.bind(this);
        this.nextButtonPress = this.nextButtonPress.bind(this);
        this.handleClick = this.handleClick.bind(this);
        this.onOverlayClick = this.onOverlayClick.bind(this);
        this.sortGenderContent = this.sortGenderContent.bind(this);
        this.sortSpeciesContent = this.sortSpeciesContent.bind(this);
        this.sortStatusContent = this.sortStatusContent.bind(this);
        this.sortContent = this.sortContent.bind(this);

        this.state = {
            pending: true,
            characters: [],
            sortedArray: [],
            prev: null,
            next: null,
            uniqueGender: [],
            uniqueStatus: [],
            uniqueSpecies: [],
            filterGender: '',
            filterSpecies: '',
            filterStatus: '',
            filterByURL: '',
            show: false, 
            nextBtnPressed: false,
            prevBtnPressed: false
        }
    }

    
    componentDidMount = () => {

        valuesURL = queryString.parse(this.props.location.search)
        console.log(this.props);
        console.log(valuesURL);
        
        this.setState({filterByURL: valuesURL }, ()=>{ 
            this.getContent(); 
        });  
        
    }

    getContent() {
        let url = API_URL;

        
        if(this.state.filterByURL.page){
            url = API_URL+"/?page="+this.state.filterByURL.page;
        } 

        if(this.state.nextBtnPressed){
            url = this.state.next;
            this.setState({nextBtnPressed: false});
        }

        if(this.state.prevBtnPressed){
            url = this.state.prev;
            this.setState({prevBtnPressed: false})
        }

        fetch(url, {
            method: 'GET',
            // body: requestData
        }).then((response) => response.json()).then((data) => {
            
            console.log(data);
            this.setState({
                characters: data.results,
                sortedArray: data.results,
                prev: data.info.prev,
                next: data.info.next               
            }, ()=> { 
                this.uniqueTags(data.results); 
                if(this.state.filterByURL.gender){
                    this.setState({filterGender: this.state.filterByURL.gender}, ()=> {
                        this.sortContent();
                    });
                }
                if(this.state.filterByURL.species){
                    this.setState({filterSpecies: this.state.filterByURL.species}, ()=> {
                        this.sortContent();
                    });
                }
                if(this.state.filterByURL.status){
                    this.setState({filterStatus: this.state.filterByURL.status}, ()=> {
                        this.sortContent();
                    });
                }
            });
            
            // var promise = fetch('API_URL/?page=' + i);\
            // , ()=> { this.uniqueTags(data.info.next); }

        }).catch((err) => {

            console.log(err);

        }).finally(() => {
            this.setState({
                pending: false
            });
        });
    }

    uniqueTags(character) {
        let uniqueGender = []; 
        let uniqueStatus = [];
        let uniqueSpecies = [];
 
        character.map((x, i) => {
    if (uniqueGender.indexOf(x.gender) === -1) {
        uniqueGender.push(x.gender)
    }
    if (uniqueStatus.indexOf(x.status) === -1) {
        uniqueStatus.push(x.status)
    }
    if (uniqueSpecies.indexOf(x.species) === -1) {
        uniqueSpecies.push(x.species)
    }

    });

    this.setState({uniqueGender: uniqueGender, uniqueStatus: uniqueStatus, uniqueSpecies: uniqueSpecies });
    }

    sortGenderContent(e) {
        this.setState({filterGender: e.target.value}, ()=> {
            this.sortContent();
        });
       
    }

    sortSpeciesContent(e) {
        this.setState({filterSpecies: e.target.value}, ()=> {
            this.sortContent();
        });
        
    }

    sortStatusContent(e) {
        this.setState({filterStatus: e.target.value}, ()=>{
            this.sortContent();
        });
        
    }
    
    sortContent(){
    
        let sortedArray = Array.prototype.slice.call(this.state.characters);

        if(this.state.filterGender){
            sortedArray = sortedArray.filter(x => {
                return x.gender == this.state.filterGender; });
        }
        if(this.state.filterSpecies){
            sortedArray = sortedArray.filter(x => {
                return x.species == this.state.filterSpecies; });
        }
        if(this.state.filterStatus){
            sortedArray = sortedArray.filter(x => {
                return x.status == this.state.filterStatus; });
        }

        console.log(sortedArray);
        this.setState({ sortedArray: sortedArray});  //e.target.value
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
        e.preventDefault();
        this.setState({ pending: true, nextBtnPressed: true}, ()=>{
            this.getContent();
        });
        
    }

    prevButtonPress(e) {
        e.preventDefault();
        this.setState({ pending: true, prevBtnPressed: true}, ()=>{
            this.getContent();
        });
    }

    renderHeader() {
        return (
            <div className="headerContainer">
                <div className="genderContainer">
                    <div className="sortby">Sort by Gender:</div>
                    <div>
                        <select id="lang" onChange={e => this.sortGenderContent(e)}>
                           {this.state.uniqueGender.map((x, i) => {
                                return (<option value={x} key={i}>{x}</option>);
                                })}    
                        </select>
                    </div>
                </div>
                <div className="spiecesContainer">
                    <div className="sortby">Sort by Spieces:</div>
                    <div>
                        <select id="lang" onChange={e => this.sortSpeciesContent(e)}>
                        {this.state.uniqueSpecies.map((y, i) => {
                                return (<option value={y} key={i}>{y}</option>);
                                })} 
                        </select>
                    </div>
                </div>
                <div className="statusContainer">
                    <div className="sortby">Sort by Status:</div>
                    <div>
                        <select id="lang" onChange={e => this.sortStatusContent(e)}>
                        {this.state.uniqueStatus.map((z, i) => {
                                return (<option value={z} key={i}>{z}</option>);
                                })} 
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

export default withRouter(Main);