import React from 'react';
import './Main.scss';


class Main extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {

        return (
            <div>
                <header class="header">
                        <div class="text-box">
                            <h1 class="heading-primary">
                                <span class="heading-primary-main">Welcome</span>
                                <span class="heading-primary-sub"></span>
                            </h1>

                            <div class="text-box-2">
                                <a href="#" class="btn btn-white btn-animate">Find your character</a>
                            </div>
                        </div>
                 </header>
           </div>
                );
        
            }
        
        }
        
export default Main;