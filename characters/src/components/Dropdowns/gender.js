import React from 'react'


const Gender = (props) => {
    return (
        <div className='drop-item'>
            <select className="drop-gender" value={props.genderValue} 
            onChange={props.genderUpdate}>
                <option value="" >Gender</option>
                <option value='male'>Male</option>
                <option value="female">Female</option>
                <option value="genderless">Genderless</option>
                <option value="unknown">Unknown</option> 
            </select>  
        </div>
    )
}

export default Gender
