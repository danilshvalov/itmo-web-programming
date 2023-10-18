cmake_minimum_required(VERSION 3.20)
project(main)

set(CMAKE_AUTOMOC ON)
set(CMAKE_INCLUDE_CURRENT_DIR ON)

find_package(Qt6 REQUIRED
  Core
  PrintSupport
  Gui
  Widgets
  WebEngineWidgets
)

add_executable(
  main
  src/main.cpp
  src/website_viewer.hpp
  src/website_viewer.cpp
  src/table_list_model.hpp
  src/website_list_model.hpp
  src/website_list_model.cpp
  src/website_list_window.hpp
  src/website_list_window.cpp
  src/website_form.hpp
  src/website_form.cpp
  src/url_validator.hpp
  src/url_validator.cpp
)

target_link_libraries(main PUBLIC
  Qt6::Widgets
  Qt6::PrintSupport
  Qt6::WebEngineWidgets
)
