import React from "react"
import { render, unmountComponentAtNode } from "react-dom"
import { act } from "react-dom/test-utils"
import { Characters } from "./Characters"

describe("Characters screen tests", () => {
  let container
  const historyMock = { push: jest.fn() }
  const mockProps = {
    location: {
      search: "?name=rick&gender=Female",
    },
    history: historyMock,
    fetchChars: () => {},
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

  it("Should contain filters", () => {
    act(() => {
      render(<Characters {...mockProps} />, container)
    })
    expect(container.getElementsByClassName("filters").length).toBe(1)
  })

  it("Should contain one reset button", () => {
    act(() => {
      render(<Characters {...mockProps} />, container)
      const buttons = container.getElementsByTagName("button")
      expect(buttons.length).toBe(1)
      expect(buttons[0].textContent).toBe("RESET")
    })
  })
})
