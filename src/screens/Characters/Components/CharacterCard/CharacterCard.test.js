import React from "react"
import { render, unmountComponentAtNode } from "react-dom"
import { act } from "react-dom/test-utils"
import CharacterCard from "./CharacterCard"

describe("Character Card component tests", () => {
  let container
  const mockProps = {
    character: {
      name: "Rick Smith",
      gender: "Male",
      episode: ["https://rickandmortyapi.com/api/episode/24"],
    },
  }

  beforeEach(() => {
    container = document.createElement("div")
    document.body.appendChild(container)
  })

  afterEach(() => {
    unmountComponentAtNode(container)
    container.remove()
    container = null
  })

  it("Card should contain character name", () => {
    act(() => {
      render(<CharacterCard {...mockProps} />, container)
    })
    expect(container.textContent).toContain(mockProps.character.name)
  })

  it("Should diplay character gender", () => {
    act(() => {
      render(<CharacterCard {...mockProps} />, container)
    })
    expect(container.textContent).toContain(mockProps.character.gender)
  })
})
