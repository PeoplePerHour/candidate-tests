import React from 'react';
import './Main.scss';
import { FaArrowLeft, FaArrowRight } from "react-icons/fa";

class Footer extends React.Component {

    renderPreviousButton = () => {

            return (
                <div className="previousContainer">
                <button className="previousButton" disabled={!this.props.footer.prev} onClick={this.props.prevButtonPress}>
                    <FaArrowLeft size={28} style={this.props.footer.prev ? {opacity: 1} : {opacity: 0.5}}/>

                </button>
                </div>
            );
    }

    renderNextButton = () => {

            return (
                <div className="nextContainer">
                <button className="nextButton" disabled={!this.props.footer.next} onClick={this.props.nextButtonPress}>
                    <FaArrowRight size={28} style={this.props.footer.next ? {opacity: 1} : {opacity: 0.5}}/>

                </button>
                </div>
            );
    }

    render() {
        let prevButton = this.renderPreviousButton();
        let nextButton = this.renderNextButton();
       

        return (
            <div className="footer">

            {prevButton}

            {nextButton}
        </div>

    );

}

}

export default Footer;