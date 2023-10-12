#pragma once

#include "url_validator.hpp"
#include "website_display_info.hpp"

#include <QLabel>
#include <QLineEdit>
#include <QMainWindow>
#include <QPushButton>
#include <QSpinBox>

class WebsiteForm : public QMainWindow {
    Q_OBJECT

   public:
    WebsiteForm(QWidget* parent = nullptr);

    void setFields(WebsiteDisplayInfo info);

    int getRow() const;

    void setRow(int row);

    void clear();

   signals:
    void submit(WebsiteDisplayInfo info);

   private:
    void onInput();

    void onSubmit(bool);

    QLabel* url_label_;
    QLineEdit* url_input_;
    UrlValidator* url_validator_;
    QLabel* show_time_label_;
    QSpinBox* show_time_input_;
    QPushButton* submit_button_;
    int row_ = -1;
};
