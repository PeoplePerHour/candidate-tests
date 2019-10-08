import React from 'react'
import axios from 'axios'
import ls from 'local-storage'
import {browserHistory} from 'react-router'

import CharactersList from './charactersList'
import PrevNext from './Buttons/Prev_Next'
import Gender from './Dropdowns/gender'
import Status from './Dropdowns/status'
import Species from './Dropdowns/species'
import FilterButtons from './Buttons/filterButtons'


const baseURL = "https://rickandmortyapi.com/api/character/"
let myLocal = ''

class Url extends React.Component {
    constructor(props) {
        super(props);
        this.state = {               
            isLoading: true,                   
            info: [],
            prevPage: null,
            nextPage: null,
            characters: [],

            characterInfo: {created: "", episode: 0, gender: "", id: 0, image: "",
            location:{name: "", url: ""}, name: "", origin:{name: "", 
            url: ""}, species: "", status: "", type: ""},

            gender: '', 
            status: '', 
            species: '',
            showPopup: false,
            toggleInfo: false,
            characterID: [],
        } 
    }

    async componentDidMount() {      
        const res = await axios.get(baseURL)
        .catch((error) => {
            // Error
            if (error.response) {
                 // status code in range of 2xx
                console.log(error.response.data);
                console.log(error.response.status);
                console.log(error.response.headers);
            } else if (error.request) {
                // no response received
                console.log(error.request);
            } else {
                // error in settings 
                console.log('Error', error.message);
            }
            console.log(error.config);
        });          
        this.setState({ info: res.data.info, characters: res.data.results, prevPage: res.data.info.prev, nextPage: res.data.info.next})
        console.log(res)   
        ls.get('pageState')
    };
        
// Previous, Next buttons 
    clickprev = async () => {
        const url = this.state.info.prev
        if (url !== '') {
            const res = await axios.get(url)            
            this.setState({ info: res.data.info, characters: res.data.results, prevPage: res.data.info.prev, nextPage: res.data.info.next })  
            console.log(res);
        }
    
    }

    clicknext = async () => {
        const url = this.state.info.next
        if (url !== '') {
            const res = await axios.get(url)            
            this.setState({ info: res.data.info, characters: res.data.results, prevPage: res.data.info.prev, nextPage: res.data.info.next })  
            console.log(res);
        }
    };

// Dropdowns
    // setting species menu
    filterUniques = () =>  {
        const species =  [...new Set(this.state.characters.map(character => 
            character.species))]
        let indexes = []
        species.forEach(function(item, index, array) {
            indexes.push(index)
            return indexes})
        return species
    }
      
    // catching dropdown values
    handleDropdownState = (event) => {
        if (event.target.className === 'drop-gender') {
            this.setState({ gender: event.target.value.toLowerCase() })
        } else if (event.target.className === 'drop-status') {
            this.setState({ status: event.target.value.toLowerCase() })
        } else if (event.target.className === 'drop-species') {            
            this.setState({ species: event.target.value.toLowerCase() })
        }
    }

// Filters buttons
    clickFilter = async () => {
        let genderFilter = (this.state.gender!==null) ? ('&gender=' + this.state.gender) : ''
        let statusFilter = (this.state.status!==null) ? ('&status=' + this.state.status) : '' 
        let speciesFilter = (this.state.species!==null) ? ('&species=' + this.state.species) : ''

        let newUrl = baseURL + '?' + genderFilter + statusFilter + speciesFilter
        const res = await axios.get(newUrl)            
          
        this.setState({ info: res.data.info, characters: res.data.results, prevPage: res.data.info.prev, nextPage: res.data.info.next }) 
        ls.set('pageState', {gender: this.state.gender, status: this.state.status,species: this.state.species}) 
        browserHistory.push('/filtered')
        console.log(res);
    }

    clearFilters = async () => {
        let newUrl = baseURL
        const res = await axios.get(newUrl)              
        this.setState({ info: res.data.info, characters: res.data.results, prevPage: res.data.info.prev, nextPage: res.data.info.next, gender: '', 
        status: '', species: '' }) 
        browserHistory.push('/home')
        myLocal = {gender: '', status: '',species: ''}   
        console.log(res);    
    }

    toggleCharInfo = (event) => {
        this.setState({ toggleInfo: !this.state.toggleInfo })
    }
// Popup
    clickPopup = async (event) => {
        const CharID = event.target.getAttribute('id');
        const newUrl = baseURL + CharID
        const res = await axios.get(newUrl)
        this.setState({ characterInfo: res.data, isLoading: false })
    }

    loadingState = () => {
        this.setState( {isLoading: true})
    }

    render() {          
        return(
            <div>
                <div className='title'>Rick and Morty Characters</div>     
         
                <CharactersList 
                loading={this.state.isLoading}
                loadingState={this.loadingState.bind(this)}
                characters={this.state.characters} 
                clickPopup={this.clickPopup.bind(this)}
                clickInfo={this.clickInfo} 
                toggleCharInfo={this.toggleCharInfo.bind(this)} toggleInfo={this.state.toggleInfo} 
                characterInfo={this.state.characterInfo}
                /> 
                }               
                

                <PrevNext clickPrev={this.clickprev.bind(this)} clickNext={this.clicknext.bind(this)} />
                
                <div className='filter-all'>
                <h2 className='filter-text'>Filters</h2>
                    <div className='dropdowns' onClick={this.savePageState}> 
                        <Gender genderValue={this.state.gender} genderUpdate={this.handleDropdownState.bind(this)} />
                        <Status statusValue={this.state.status} statusUpdate={this.handleDropdownState.bind(this)}/>
                        <Species speciesValue={this.state.species} speciesUpdate={this.handleDropdownState.bind(this)}
                            filterUniques={this.filterUniques} />
                    </div>
                    <FilterButtons clickFilter={this.clickFilter.bind(this)} 
                    clearFilter={this.clearFilters.bind(this)} />
                </div>
                <div className='bottom-div'></div>
            </div>
        )
    }
}

export default Url
