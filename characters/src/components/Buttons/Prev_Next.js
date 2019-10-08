import React from 'react'

const Prev_Next = (props) => {
    return (
        <div className="prevNext">
            <button type="button" className='prev-b' onClick={props.clickPrev}>Previous</button>
            <button type="button" className='next-b' onClick={props.clickNext}>Next</button> 
        </div>
    )
}

export default Prev_Next
