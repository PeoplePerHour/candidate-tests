import React from 'react'

const Species = (props) => {
    
    return (
        <div className='drop-item'>
            <select className="drop-species" value={props.speciesValue} 
                onChange={props.speciesUpdate}>
                <option value="">{(props.speciesValue === '')? 'Species' : props.speciesValue.charAt(0).toUpperCase()+props.speciesValue.slice(1) } </option>   
                    {props.filterUniques().map((spec, i) => 
                    <option key={i} value={spec}>
                        {spec}
                    </option>)
                    } 
            </select> 
        </div>
    )
}

export default Species
