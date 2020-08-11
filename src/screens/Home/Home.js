import React, { Component } from "react"
import { Link } from "react-router-dom"
import "./home.scss"
import logo from "../../assets/rnm.png"

class Home extends Component {
  render() {
    return (
      <div className="home">
        <Link to="/characters">EXPLORE CHARACTERS</Link>
        <img loading="lazy" src={logo} alt="" />
      </div>
    )
  }
}

export default Home
