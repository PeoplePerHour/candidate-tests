import React from 'react';
import './Main.scss';
import CharacterCard from '../CharacterCard/CharacterCard';
import { API_URL } from '../../config';

class Main extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            pending: false,
            characters: [],
            prev: null,
            next: null,
            filter: false,
            gender: '',
            spieces: '',
            status: ''
        }
    }



    getContent() {

        console.log(`Retrieving content`);

        fetch(API_URL, {
            method: 'GET',
            // body: requestData
        }).then((response) => response.json()).then((data) => {

              console.log(data);
              this.setState({
                characters: data.results,
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

    componentDidMount = () => {

        this.getContent();
    }


    render() {

        return (<div className="main">
             {this.state.characters.map((character, i) => (
                  <CharacterCard character={character} key={i} handleClick={this.handleClick} />
                ))}
        </div>

        );

    }

}

export default Main;