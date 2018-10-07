import React from 'react';
import { Link } from 'react-router-dom';
import './Landing.scss';


class Landing extends React.Component {

    render() {

        return (
            <div>
                <header className="header">
                    <div className="text-box">
                        <h1 className="heading-primary">
                            <span className="heading-primary-main">Welcome</span>
                            <span className="heading-primary-sub"></span>
                        </h1>

                        <div className="text-box-2">
                            <Link to={'/main'} className="btn btn-white btn-animate">Find your character</Link>
                        </div>
                    </div>
                </header>
                
            </div>
        );

    }

}

export default Landing;