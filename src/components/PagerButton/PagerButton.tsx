import * as React from "react";
import {PropsWithChildren} from 'react'


interface IProps{
    handleNavigate(page:string,num:number):void
    text:string
    querySting?:any
    link?:any
}

const PagerButton:React.FC<IProps> = (props:PropsWithChildren<IProps>) =>{

const {link,handleNavigate,text}=props

const handleClick=(e: React.MouseEvent<HTMLButtonElement, MouseEvent>)=>{
    e.preventDefault()
    let url = new URL(link);
    let params = new URLSearchParams(url.search.slice(1));
    let num = parseInt(params.get("page"));
    handleNavigate('page',num)
}
return <button className='btn' disabled={link==""?true:false} onClick={(e)=>handleClick(e)}>{text}</button>
};

export default PagerButton;
