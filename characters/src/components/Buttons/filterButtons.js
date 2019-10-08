import React from 'react'

const filterButtons = (props) => {
    return (
        <div className='filters'>
            <div className="ui floating labeled icon button segment filter-btn" onClick={props.clickFilter}>
                <i className="filter icon"></i>
                <span className="text">Filter</span>  
            </div>
            
            <div>
                <button type="button" className='ui button filter segment clear-btn' onClick={props.clearFilter}>
                <div className='filter-i'>
                <i className="home icon"></i></div>Clear All</button>  
            </div>
        </div>
    )
}

export default filterButtons;
