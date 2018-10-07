import React from 'react';
import './Main.scss';
import CharacterCard from '../CharacterCard/CharacterCard';
import Footer from './Footer';
import { API_URL } from '../../config';

import Loader from 'react-loader-spinner';

class Main extends React.Component {

    constructor(props) {
        super(props);

        this.prevButtonPress = this.prevButtonPress.bind(this);
        this.nextButtonPress = this.nextButtonPress.bind(this);

        this.state = {
            pending: true,
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

    nextButtonPress(e) {
        e.preventDefault();
        fetch(this.state.next, {
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
    
      prevButtonPress(e) {
        e.preventDefault();
        fetch(this.state.prev, {
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

    renderBody() {
        if (this.state.characters && !this.state.pending) {
            return (
                <div>

                    {this.state.characters.map((character, i) => (
                        <CharacterCard character={character} key={i} handleClick={this.handleClick} />
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
        let body = this.renderBody();

        return (
            <div className="app">
                <div className="mainHeader">
                    <div>welcome</div>
                </div>
                <div className="main">
                    {body}
                </div>
                <Footer footer={this.state} nextButtonPress = {this.nextButtonPress} prevButtonPress = {this.prevButtonPress}/>
               
            </div>

        );

    }

}

export default Main;